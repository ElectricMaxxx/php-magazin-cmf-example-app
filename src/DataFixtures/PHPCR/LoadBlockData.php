<?php

namespace App\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Util\NodeHelper;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ContainerBlock;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\StringBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadBlockData implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager|DocumentManager $manager
     *         --env MYSQL_ALLOW_EMPTY_PASSWORD="yes" MYSQL_DATABASE="prb" MYSQL_ROOT_PASSWORD="root" MYSQL_USER="cmr" MYSQL_PASSWORD="cmf"
     */
    public function load(ObjectManager $manager)
    {
        $blockBasepath = $this->container->getParameter('cmf_block.persistence.phpcr.block_basepath');
        NodeHelper::createPath($manager->getPhpcrSession(), $blockBasepath);
        $blocksHome = $manager->find(null, $blockBasepath);

        $blockContainer = new ContainerBlock();
        $blockContainer->setParentDocument($blocksHome);
        $blockContainer->setName('blocks');

        foreach (['A', 'B', 'C'] as $key) {
            $block = new StringBlock();
            $block->setParentDocument($blockContainer);
            $block->setName('block-'.strtolower($key));
            $block->setBody('Inhalt von Block '.$key);
            $manager->persist($block);
        }
        
        $manager->flush();
    }
}
