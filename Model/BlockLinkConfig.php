<?php

namespace Zorbus\LinkBundle\Model;

use Zorbus\BlockBundle\Entity\Block as BlockEntity;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\Form\FormFactory;
use Zorbus\BlockBundle\Model\BlockConfig;

class BlockLinkConfig extends BlockConfig
{

    public function __construct(AdminInterface $admin, FormFactory $formFactory, $httpKernel)
    {
        parent::__construct('zorbus_link.block.link', 'Link Block', $admin, $formFactory);
        $this->enabled = true;
        $this->themes = array(
            'ZorbusLinkBundle:Block:link' => 'Default'
            );
        $this->httpKernel = $httpKernel;
    }

    public function getFormMapper()
    {
        return $this->formMapper
                        ->add('link', 'entity', array(
                            'class' => 'Zorbus\\LinkBundle\\Entity\\Link',
                            'attr' => array('class' => 'span5 select2')
                        ))
                        ->add('name', 'text')
                        ->add('lang', 'text', array('required' => false))
                        ->add('theme', 'choice', array(
                            'choices' => $this->getThemes(),
                            'attr' => array('class' => 'span5 select2')
                        ))
                        ->add('cache_ttl', 'integer', array(
                            'required' => false,
                            'attr' => array('class' => 'span2')
                        ))
                        ->add('enabled', 'checkbox', array('required' => false))
        ;
    }

    public function getBlockEntity(array $data, BlockEntity $block = null)
    {
        $block = null === $block ? new BlockEntity() : $block;

        $block->setService($this->getService());
        $block->setCategory('Link');
        $block->setParameters(json_encode(array('link_id' => $data['link']->getId())));
        $block->setName($data['name']);
        $block->setLang($data['lang']);
        $block->setTheme($data['theme']);
        $block->setEnabled((boolean) $data['enabled']);
        $block->setCacheTtl($data['cache_ttl']);

        return $block;
    }

    public function render(BlockEntity $block, $page = null, $request = null)
    {
        if ($block->getService() != $this->getService())
        {
            throw new \InvalidArgumentException('Block service not supported');
        }

        $response = $this->httpKernel->forward($block->getTheme(), array('block' => $block, 'page' => $page, 'request' => $request));

        return $response;
    }

}