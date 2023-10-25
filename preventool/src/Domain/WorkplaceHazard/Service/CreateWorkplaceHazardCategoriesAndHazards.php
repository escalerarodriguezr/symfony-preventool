<?php
declare(strict_types=1);

namespace Preventool\Domain\WorkplaceHazard\Service;


use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazardCategory;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardCategoryRepository;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardRepository;

class CreateWorkplaceHazardCategoriesAndHazards
{


    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly WorkplaceHazardCategoryRepository $workplaceHazardCategoryRepository,
        private readonly WorkplaceHazardRepository $hazardRepository
    )
    {
    }

    public function __invoke(Workplace $workplace):void
    {
        //Fisicos
        $fisicosCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Físicos')
        );
        $fisicosCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($fisicosCategory);
            $this->hazardRepository->save(
                new WorkplaceHazard(
                    new Uuid($this->identityGenerator->generateId()),
                    $workplace,
                    $fisicosCategory,
                    new Name('Ruido')
                )
            );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $fisicosCategory,
                new Name('Temperaturas extremas')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $fisicosCategory,
                new Name('Vibraciones')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $fisicosCategory,
                new Name('Radiaciones')
            )
        );

        //Químicos
        $quimicosCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Químicos')
        );
        $quimicosCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($quimicosCategory);
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $quimicosCategory,
                new Name('Polvos')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $quimicosCategory,
                new Name('Vapores tóxicos')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $quimicosCategory,
                new Name('Gases tóxicos')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $quimicosCategory,
                new Name('Humos metálicos')
            )
        );


        //Biológicos
        $bioCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Biológicos')
        );
        $bioCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($bioCategory);
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $bioCategory,
                new Name('Bacterias')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $bioCategory,
                new Name('Hongos')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $bioCategory,
                new Name('Vurus')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $bioCategory,
                new Name('Plagas')
            )
        );

        //Disergnómicos
        $diserCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Disergonómicos')
        );
        $diserCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($diserCategory);
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $diserCategory,
                new Name('Posturas inadecuadas')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $diserCategory,
                new Name('Movimientos repetitivos')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $diserCategory,
                new Name('Levantamiento de cargas')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $diserCategory,
                new Name('Sobreesfuerzo')
            )
        );


        //Psicosociales
        $psicoCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Psicosociales')
        );
        $psicoCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($psicoCategory);

        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $psicoCategory,
                new Name('Estrés')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $psicoCategory,
                new Name('Carga de trabajo y ritmo excesivo')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $psicoCategory,
                new Name('Contenido del trabajo')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $psicoCategory,
                new Name('Mobbing')
            )
        );

        //Físico-Químicos
        $fsico_quimiCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Físico-Químicos')
        );
        $fsico_quimiCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($fsico_quimiCategory);
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $fsico_quimiCategory,
                new Name('Incendios')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $fsico_quimiCategory,
                new Name('Explosiones')
            )
        );

        //Locativos
        $locativosCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Locativos')
        );
        $locativosCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($locativosCategory);

        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $locativosCategory,
                new Name('Máquinas sin protección')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $locativosCategory,
                new Name('Herramienta defectuosa')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $locativosCategory,
                new Name('Vehículo en mal estado')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $locativosCategory,
                new Name('Calderos sin mantenimiento')
            )
        );

        //Eléctricos
        $electricosCategory = new WorkplaceHazardCategory(
            new Uuid($this->identityGenerator->generateId()),
            $workplace,
            new Name('Eléctricos')
        );
        $electricosCategory->setCreatorAdmin($workplace->getCreatorAdmin());
        $this->workplaceHazardCategoryRepository->save($electricosCategory);
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $electricosCategory,
                new Name('Tableros eléctricos deteriorados')
            )
        );
        $this->hazardRepository->save(
            new WorkplaceHazard(
                new Uuid($this->identityGenerator->generateId()),
                $workplace,
                $electricosCategory,
                new Name('Cables eléctricos expuestos')
            )
        );

    }


}