<?php

namespace Zorbus\LinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function linkAction($block, $page, $request)
    {
        $parameters = json_decode($block->getParameters());
        $link = $this->getDoctrine()->getRepository('ZorbusLinkBundle:Link')->find($parameters->link_id);

        return $this->render('ZorbusLinkBundle:Block:link.html.twig', array(
            'block' => $block, 'link' => $link
        ));
    }
    public function categoryAction($block, $page, $request)
    {
        $parameters = json_decode($block->getParameters());
        $category = $this->getDoctrine()->getRepository('ZorbusLinkBundle:Category')->find($parameters->category_id);
        $links = $category->getLinks();

        return $this->render('ZorbusLinkBundle:Block:category.html.twig', array(
            'block' => $block, 'category' => $category, 'links' => $links
        ));
    }
    public function categoriesAction($block, $page, $request)
    {
        $parameters = json_decode($block->getParameters());
        $categories = $this->getDoctrine()->getRepository('ZorbusLinkBundle:Category')->getCategoriesWithLinks($parameters->category_ids);

        return $this->render('ZorbusLinkBundle:Block:categories.html.twig', array(
            'block' => $block, 'categories' => $categories
        ));
    }
}
