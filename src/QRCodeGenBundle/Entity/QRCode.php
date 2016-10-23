<?php
namespace QRCodeGenBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * QRCode data class for better formm holding
 */
class QRCode
{
    /**
     * @Assert\NotBlank(message = "Can't be blank")
     * @Assert\Length(min = 1, minMessage = "Must be at least {{ limit }} chars long")
     * @Assert\Regex(pattern="/^[a-z0-9\s]+$/i", message="Can be a-z, 0-9, spaces")
     * @var string
     */
    protected $text;

    /**
     * @Assert\NotBlank(message = "Can't be blank")
     * @Assert\Range(
     *     min = 30, minMessage = "Must be at least {{ limit }} chars long",
     *     max = 500, maxMessage = "Can't be more 500 chars long"
     * )
     * @var int
     */
    protected $width;

    /**
     * @Assert\NotBlank(message = "Can't be blank")
     * @Assert\Range(
     *     min = 30, minMessage = "Must be at least {{ limit }} chars long",
     *     max = 500, maxMessage = "Can't be more 500 chars long"
     * )
     * @var int
     */
    protected $height;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return QRCode
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return QRCode
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return QRCode
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
}
