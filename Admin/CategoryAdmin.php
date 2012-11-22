<?php

namespace Zorbus\LinkBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\Image;

class CategoryAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('constraints' => array(
                        new NotBlank(),
                        new MaxLength(array('limit' => 255))
                    )
                ))
                ->add('description', 'textarea', array(
                    'required' => false,
                    'attr' => array('class' => 'ckeditor')
                ))
                ->add('imageTemp', 'file', array(
                    'required' => false,
                    'label' => 'Image',
                    'constraints' => array(
                        new Image()
                    )
                ))
                ->add('enabled')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name')
                ->add('enabled')
        ;
    }

    public function configureShowFields(ShowMapper $filter)
    {
        $filter
                ->add('name')
                ->add('description', 'text', array('safe' => true))
                ->add('image')
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