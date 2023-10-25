<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Company;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UploadHealthAndSafetyPolicyRequest implements RequestDTO
{

    const FILE_INPUT = 'policy';

    /**
     * @Assert\NotBlank
     * @Assert\File(

     *     mimeTypes = {"application/pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     */
    private UploadedFile $policy;


    public function __construct(
        Request $request
    )
    {
        $this->policy = $request->files->get(self::FILE_INPUT);

    }

    public function getPolicy(): UploadedFile
    {
        return $this->policy;
    }


}