<?php

namespace Preventool\Infrastructure\Ui\Http\Request\DTO;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDemoRequest implements RequestDTO
{
    const NAME_PARAM = 'name';
    const WIDTH_PARAM = 'width';
    const HEIGHT_PARAM = 'height';
    const BLOCKS_PARAMS = 'numberOfRandomBlocks';

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'name'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'name'."
     * )
     */
    private mixed $name;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'width'.")
     * @Assert\Type(
     *     type="integer",
     *     message = "Missing or invalid value of request parameter 'width'."
     * )
     */
    private mixed $width;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'height'.")
     * @Assert\Type(
     *     type="integer",
     *     message = "Missing or invalid value of request parameter 'height'."
     * )
     */
    private mixed $height;

    /**
     * @Assert\Type(
     *     type="integer",
     *     message = "Invalid value of request parameter 'numberOfRandomBlocks'."
     * )
     */
    private mixed $numberOfRandomBlocks;

    public function __construct(Request $request)
    {
        $this->name = $request->query->get(self::NAME_PARAM);
        $this->width = is_numeric($request->query->get(self::WIDTH_PARAM)) ? (int) $request->query->get(self::WIDTH_PARAM) : null;
        $this->height = is_numeric($request->query->get(self::HEIGHT_PARAM)) ? (int) $request->query->get(self::HEIGHT_PARAM) : null;
        $this->numberOfRandomBlocks = is_numeric($request->query->get(self::BLOCKS_PARAMS)) ? (int) $request->query->get(self::BLOCKS_PARAMS) : 0;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getNumberOfRandomBlocks(): int
    {
        return $this->numberOfRandomBlocks;
    }


}