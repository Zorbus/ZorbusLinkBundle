<?php

namespace Zorbus\LinkBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
abstract class Category
{
    protected $imageTemp;

    public function __toString()
    {
        return $this->getName();
    }

    public function getImageTemp()
    {
        return $this->imageTemp;
    }

    public function setImageTemp($image)
    {
        $this->imageTemp = $image;
    }

    public function getAttachmentTemp()
    {
        return $this->attachmentTemp;
    }

    public function setAttachmentTemp($attachment)
    {
        $this->attachmentTemp = $attachment;
    }

    public function getAbsolutePath($file)
    {
        return null === $file ? null : $this->getUploadRootDir() . '/' . $file;
    }

    public function getWebPath($file)
    {
        return null === $file ? null : $this->getUploadDir() . '/' . $file;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/link';
    }
}
