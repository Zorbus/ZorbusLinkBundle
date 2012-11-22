<?php

namespace Zorbus\LinkBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Min;

class LinkAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('Identification')
                    ->add('title', null, array('constraints' => array(
                        new NotBlank(),
                        new MaxLength(array('limit' => 255))
                    )))
                    ->add('url', null, array('constraints' => array(
                        new NotBlank(),
                        new Url()
                    )))
                    ->add('category', null, array('constraints' => array(
                        new Type(array('type' => 'Zorbus\LinkBundle\Entity\Category')),
                    )))
                    ->add('target', 'choice', array(
                        'choices' => array('_self' => 'Self', '_blank' => 'Blank'),
                        'constraints' => array(
                            new Choice(array('choices' => array('_self', '_blank')))
                        )
                    ))
                ->end()
                ->with('Configuration', array('collapsed' => false))
                    ->add('description', 'textarea', array('required' => false, 'attr' => array('class' => 'ckeditor')))
                    ->add('imageTemp', 'file', array(
                        'required' => false,
                        'label' => 'Image',
                        'constraints' => array(
                            new Image()
                        )
                    ))
                    ->add('position', null, array(
                        'required' => false,
                        'constraints' => array(
                            new Min(array('limit' => 0))
                        )
                    ))
                    ->add('enabled', null, array('required' => false))
                ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('title')
                ->add('url')
                ->add('category')
                ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('title')
                ->add('url')
                ->add('enabled')
        ;
    }

    public function configureShowFields(ShowMapper $filter)
    {
        $filter
                ->add('title')
                ->add('url')
                ->add('category')
                ->add('enabled')
        ;
    }

    public function prePersist($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

}