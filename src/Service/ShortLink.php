<?php

namespace App\Service;

use App\Entity\ShortLink as ShortLinkEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ShortLink
 *
 * @package App\Service
 */
class ShortLink
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository  */
    private $repository;

    /**
     * ShortLink constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ShortLinkEntity::class);
    }

    /**
     * @param string $url
     * @param string $clientIp
     *
     * @return null|object
     */
    public function findShortLink(string $url, string $clientIp): ?ShortLinkEntity
    {
        return $this->repository->findOneBy([
            'url' => $url,
            'client_ip' => $clientIp
        ]);
    }

    /**
     * @param string $url
     * @param string $clientIp
     *
     * @return ShortLinkEntity
     */
    public function createNewShortLink(string $url, string $clientIp): ShortLinkEntity
    {
        $shortLink = new ShortLinkEntity();
        $shortLink->setSlug($this->generateRandomString());
        $shortLink->setUrl($url);
        $shortLink->setClientIp($clientIp);
        $shortLink->setHits(0);
        $shortLink->setDate(new \DateTime("now"));
        $this->entityManager->persist($shortLink);
        $this->entityManager->flush();

        return $shortLink;
    }

    /**
     * @return string
     */
    protected function generateRandomString(): string
    {

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
