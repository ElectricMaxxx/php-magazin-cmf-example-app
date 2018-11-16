<?php

namespace App\Description;

use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\SimpleBlock;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\StringBlock;
use Symfony\Cmf\Component\Resource\Description\Description;
use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Symfony\Cmf\Component\Resource\Puli\Api\PuliResource;
use Symfony\Cmf\Component\Resource\Repository\Resource\CmfResource;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class BlockPropertyEnhancer implements DescriptionEnhancerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $manager;
    /**
     * @var Connection
     */
    private $session;

    /**
     * @param ManagerRegistry $manager
     * @param $sessionName
     */
    public function __construct(ManagerRegistry $manager, $sessionName)
    {
        $this->session = $manager->getConnection($sessionName);
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function enhance(Description $description)
    {
        $payload = $description->getResource()->getPayload();
        $properties = [];
        switch (true) {
            case $payload instanceof StringBlock:
                $properties['body'] = $payload->getBody();
                break;
            case $payload instanceof SimpleBlock:
                $properties['title'] = $payload->getTitle();
                $properties['body'] = $payload->getBody();
                break;
        }

        $description->set('properties', $properties);
    }

    /**
     * @inheritdoc
     */
    public function supports(PuliResource $resource)
    {
        if (false === $resource instanceof CmfResource) {
            return false;
        }

        $payload = $resource->getPayload();

        return $payload instanceof BlockInterface;
    }

}
