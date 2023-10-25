<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Service;

use Preventool\Domain\BaselineStudy\Model\BaselineStudy;

class GetBaselineStudyIndicatorsService
{
    /**
     * @var BaselineStudy[]
     */
    private array $indicators;

    public function __construct()
    {
        $this->setIndiators();
    }

    /**
     * @return BaselineStudy[]
     */
    public function __invoke(): array
    {
        return $this->indicators;
    }



    private function setIndiators(): void
    {
       $this->indicators = [
           'compromiso' => [
               'id' => 'compromiso',
               'name' => 'Compromiso e Involucramiento',
               'indicators' => [
                   'principios-1' => [
                       'id' => 'principios-1',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'El empleador proporciona los recursos necesarios paraque se implemente un sistema de gestión de seguridad y salud en el trabajo.'
                   ],
                   'principios-2' => [
                       'id' => 'principios-2',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se ha cumplido lo planificado en los diferentes programas de seguridad y salud en el trabajo.'
                   ],
                   'principios-3' => [
                       'id' => 'principios-3',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se implementan acciones preventivas de seguridad y salud en el trabajo para asegurar la mejora continua.'
                   ],
                   'principios-4' => [
                       'id' => 'principios-4',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se reconoce el desempeño del trabajador para mejorar la autoestima y se fomenta el trabajo en equipo.'
                   ],
                   'principios-5' => [
                       'id' => 'principios-5',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se realizan actividades para fomentar una cultura de prevención de riesgos del trabajo en toda la empresa, entidad pública o privada.'
                   ],
                   'principios-6' => [
                       'id' => 'principios-6',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se promueve un buen clima laboral para reforzar la empatía entre empleador y trabajador y viceversa.'
                   ],
                   'principios-7' => [
                       'id' => 'principios-7',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Existen medios que permiten el aporte de los trabajadores al empleador en materia de seguridad y salud en el trabajo.'
                   ],
                   'principios-8' => [
                       'id' => 'principios-8',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Existen mecanismos de reconocimiento del personal proactivo interesado en el mejoramiento continuo de la seguridad y salud en el trabajo.'
                   ],
                   'principios-9' => [
                       'id' => 'principios-9',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se tiene evaluado los principales riesgos que ocasionan mayores pérdidas.'
                   ],
                   'principios-10' => [
                       'id' => 'principios-10',
                       'name' => 'Principios',
                       'category' => 'compromiso',
                       'description' => 'Se fomenta la participación de los representantes de trabajadores y de las organizaciones sindicales en las decisiones sobre la seguridad y salud en el trabajo.'
                   ]
               ]
           ],

           'politica' => [
               'id' => 'politica',
               'name' => 'Política de seguridad y salud ocupacional',
               'indicators' => [
                   'politica-1' => [
                       'id' => 'politica-1',
                       'name' => 'Política',
                       'category' => 'politica',
                       'description' => 'Existe una política documentada en materia de seguridad y salud en el trabajo, específica y apropiada para la empresa, entidad pública o privada.'
                   ],
                   'politica-2' => [
                       'id' => 'politica-2',
                       'name' => 'Política',
                       'category' => 'politica',
                       'description' => 'La política de seguridad y salud en el trabajo está firmada por la máxima autoridad de la empresa, entidad pública o privada.'
                   ],
                   'politica-3' => [
                       'id' => 'politica-3',
                       'name' => 'Política',
                       'category' => 'politica',
                       'description' => 'Los trabajadores conocen y están comprometidos con lo establecido en la política de seguridad y salud en el trabajo.'
                   ],
                   'politica-4' => [
                       'id' => 'politica-4',
                       'name' => 'Política',
                       'category' => 'politica',
                       'description' => 'Su contenido comprende: 
                       -El compromiso de protección de todos los miembros de la organización. 
                       -Cumplimiento de la normatividad. 
                       -Garantía de protección, participación, consulta y participación en los elementos del sistema de gestión de seguridad y salud en el trabajo por parte de los trabajadores y sus representantes.
                       -La mejora continua en materia de seguridad y salud en el trabajo.
                       -Integración del Sistema de Gestión de Seguridad y Salud en el Trabajo con otros sistemas de ser el caso.'
                   ],

                   'direccion-1' => [
                       'id' => 'direccion-1',
                       'name' => 'Dirección',
                       'category' => 'politica',
                       'description' => 'Se toman decisiones en base al análisis de inspecciones, auditorias,informes de investigación de accidentes, informe de estadísticas, avances de programas de seguridad y salud en el trabajo y opiniones de trabajadores, dando el seguimiento de las mismas.'
                   ],
                   'direccion-2' => [
                       'id' => 'direccion-2',
                       'name' => 'Dirección',
                       'category' => 'politica',
                       'description' => 'El empleador delega funciones y autoridad al personal encargado de implementar el sistema de gestión de Seguridad y Salud en el Trabajo.'
                   ],

                   'liderazgo-1' => [
                       'id' => 'liderazgo-1',
                       'name' => 'Liderazgo',
                       'category' => 'politica',
                       'description' => 'El empleador asume el liderazgo en la gestión de la seguridad y salud en el trabajo.'
                   ],
                   'liderazgo-2' => [
                       'id' => 'liderazgo-2',
                       'name' => 'Liderazgo',
                       'category' => 'politica',
                       'description' => 'El empleador dispone los recursos necesarios para mejorar la gestión de la seguridad y salud en el trabajo.'
                   ],
                   'organizacion-1' => [
                       'id' => 'organizacion-1',
                       'name' => 'Organización',
                       'category' => 'politica',
                       'description' => 'Existen responsabilidades específicas en seguridad y salud en el trabajo de los niveles de mando de la empresa, entidad pública o privada.'
                   ],
                   'organizacion-2' => [
                       'id' => 'organizacion-2',
                       'name' => 'Organización',
                       'category' => 'politica',
                       'description' => 'Se ha destinado presupuesto para implementar o mejorar el sistema de gestión de seguridad y salud el trabajo.'
                   ],
                   'organizacion-3' => [
                       'id' => 'organizacion-3',
                       'name' => 'Organización',
                       'category' => 'politica',
                       'description' => 'El Comité o Supervisor de Seguridad y Salud en el Trabajo participa en la definición de estímulos y sanciones.'
                   ],
                   'competencia-1' => [
                       'id' => 'competencia-1',
                       'name' => 'Competencia',
                       'category' => 'politica',
                       'description' => 'El empleador ha definido los requisitos de competencia necesarios para cada puesto de trabajo y adopta disposiciones de capacitación en materia de seguridad y salud en el trabajo para que éste asuma sus deberes con responsabilidad.'
                   ],

               ]
           ],

           'planeamiento' => [
               'id' => 'planeamiento',
               'name' => 'Planeamiento y aplicación',
               'indicators' => [
                   'diagnostico-1' => [
                       'id' => 'diagnostico-1',
                       'name' => 'Diagnóstico',
                       'category' => 'planeamiento',
                       'description' => 'Se ha realizado una evaluación inicial o estudio de línea base como diagnóstico participativo del estado de la salud y seguridad en el trabajo.'
                   ],
                   'diagnostico-2' => [
                       'id' => 'diagnostico-2',
                       'name' => 'Diagnóstico',
                       'category' => 'planeamiento',
                       'description' => 'Los resultados han sido comparados con lo establecido en la Ley de SST y su Reglamento y otros dispositivos legales pertinentes, y servirán de base para planificar, aplicar el sistema y como referencia para medir su mejora continua.'
                   ],
                   'diagnostico-3' => [
                       'id' => 'diagnostico-3',
                       'name' => 'Diagnóstico',
                       'category' => 'planeamiento',
                       'description' => 'La planificación permite:
                       -Cumplir con normas nacionales.
                       -Mejorar el desempeño.
                       -Mantener procesos productivos seguros o de servicios seguros.'
                   ],
                   'planeamiento_iper-1' => [
                       'id' => 'planeamiento_iper-1',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'El empleador ha establecido procedimientos para identificar peligros y evaluar riesgos.'
                   ],
                   'planeamiento_iper-2' => [
                       'id' => 'planeamiento_iper-2',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'Comprende estos procedimientos:
                       -Todas las actividades.
                       -Todo el personal.
                       -Todas las instalaciones'
                   ],
                   'planeamiento_iper-3' => [
                       'id' => 'planeamiento_iper-3',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'El empleador aplica medidas para:
                       -Gestionar, eliminar y controlar riesgos.
                       -Diseñar ambiente y puesto de trabajo, seleccionar equipos y métodos de trabajo que garanticen la seguridad y salud del trabajador.
                       -Eliminar las situaciones y agentes peligrosos o sustituirlos.
                       -Modernizar los planes y programas de prevención de riesgos laborales.
                       -Mantener políticas de protección.
                       -Capacitar anticipadamente al trabajador.'
                   ],
                   'planeamiento_iper-4' => [
                       'id' => 'planeamiento_iper-4',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'El empleador actualiza la evaluación de riesgo una (01) vez al año como mínimo o cuando cambien las condiciones o se hayan producido daños.'
                   ],
                   'planeamiento_iper-5' => [
                       'id' => 'planeamiento_iper-5',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'La evaluación de riesgo considera:
                       -Controles periódicos de las condiciones de trabajo y de la salud de los trabajadores.
                       -Medidas de prevención.'
                   ],
                   'planeamiento_iper-6' => [
                       'id' => 'planeamiento_iper-6',
                       'name' => 'Planeamiento para la identificación de peligros, evaluación y control de riesgos',
                       'category' => 'planeamiento',
                       'description' => 'Los representantes de los trabajadores han participado en la identificación de peligros y evaluación de riesgos, han sugerido las medidas de control y verificado su aplicación.'
                   ],
                   'objetivos-1' => [
                       'id' => 'objetivos-1',
                       'name' => 'Objetivos',
                       'category' => 'planeamiento',
                       'description' => 'Los objetivos se centran en el logro de resultados realistas y posibles de aplicar, que comprende:
                       -Reducción de los riesgos del trabajo.
                       -Reducción de los accidentes de trabajo y enfermedades ocupacionales.
                       -La mejora continua de los procesos, la gestión del cambio, la preparación y respuesta a situaciones de emergencia.
                       -Definición de metas, indicadores, responsabilidades.
                       -Selección de criterios de medición para confirmar su logro.'
                   ],
                   'objetivos-2' => [
                       'id' => 'objetivos-2',
                       'name' => 'Objetivos',
                       'category' => 'planeamiento',
                       'description' => 'La empresa, entidad pública o privada cuenta con objetivos cuantificables de seguridad y salud en el trabajo que abarca a todos los niveles de la organización y están documentados.'
                   ],
                   'programa_sst-1' => [
                       'id' => 'programa_sst-1',
                       'name' => 'Programa de seguridad y salud en el trabajo',
                       'category' => 'planeamiento',
                       'description' => 'Existe un programa anual de seguridad y salud en el trabajo.'
                   ],
                   'programa_sst-2' => [
                       'id' => 'programa_sst-2',
                       'name' => 'Programa de seguridad y salud en el trabajo',
                       'category' => 'planeamiento',
                       'description' => 'Se definen responsables de las actividades en el programa de seguridad y salud en el trabajo.'
                   ],
                   'programa_sst-3' => [
                       'id' => 'programa_sst-3',
                       'name' => 'Programa de seguridad y salud en el trabajo',
                       'category' => 'planeamiento',
                       'description' => 'Se definen tiempos y plazos para el cumplimiento y se realiza seguimiento periódico.'
                   ],
                   'programa_sst-4' => [
                       'id' => 'programa_sst-4',
                       'name' => 'Programa de seguridad y salud en el trabajo',
                       'category' => 'planeamiento',
                       'description' => 'Se establecen actividades preventivas ante los riesgos que inciden en la función de procreación del trabajador.'
                   ],
               ]
           ],

           'implementacion' => [
               'id' => 'implementacion',
               'name' => 'Implementación y operación',
               'indicators' => [
                   'estructura-1' => [
                       'id' => 'estructura-1',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El Comité de Seguridad y Salud en el Trabajo está constituido de forma paritaria. (Para el caso de empleadores con 20 o más trabajadores).'
                   ],
                   'estructura-2' => [
                       'id' => 'estructura-2',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'Existe al menos un Supervisor de Seguridad y Salud (para el caso de empleadores con menos de 20 trabajadores).'
                   ],
                   'estructura-3' => [
                       'id' => 'estructura-3',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El empleador es responsable de:
                       -Garantizar la seguridad y salud de los trabajadores.
                       -Actúa para mejorar el nivel de seguridad y salud en el trabajo.
                       -Actúa en tomar medidas de prevención de riesgo ante modificaciones de las condiciones de trabajo.
                       -Realiza los exámenes médicos ocupacionales al trabajador antes, durante y al término de la relación laboral.'
                   ],
                   'estructura-4' => [
                       'id' => 'estructura-4',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El empleador considera las competencias del trabajador en materia de seguridad y salud en el trabajo, al asignarle sus labores.'
                   ],
                   'estructura-5' => [
                       'id' => 'estructura-5',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El empleador controla que solo el personal capacitado y protegido acceda a zonas de alto riesgo.'
                   ],
                   'estructura-6' => [
                       'id' => 'estructura-6',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El empleador prevé que la exposición a agentes físicos, químicos, biológicos, disergonómicos y psicosociales no generen daño al trabajador o trabajadora.'
                   ],
                   'estructura-7' => [
                       'id' => 'estructura-7',
                       'name' => 'Estructura y responsabilidades',
                       'category' => 'implementacion',
                       'description' => 'El empleador asume los costos de las acciones de seguridad y salud ejecutadas en el centro de trabajo.'
                   ],

                   'capacitacion-1' => [
                       'id' => 'capacitacion-1',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'El empleador toma medidas para transmitir al trabajador información sobre los riesgos en el centro de trabajo y las medidas de protección que corresponda.'
                   ],
                   'capacitacion-2' => [
                       'id' => 'capacitacion-2',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'El empleador imparte la capacitación dentro de la jornada de trabajo.'
                   ],
                   'capacitacion-3' => [
                       'id' => 'capacitacion-3',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'El costo de las capacitaciones es íntegramente asumido por el empleador.'
                   ],
                   'capacitacion-4' => [
                       'id' => 'capacitacion-4',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'Los representantes de los trabajadores han revisado el programa de capacitación.'
                   ],
                   'capacitacion-5' => [
                       'id' => 'capacitacion-5',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'La capacitación se imparte por personal competente y con experiencia en la materia.'
                   ],
                   'capacitacion-6' => [
                       'id' => 'capacitacion-6',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'Se ha capacitado a los integrantes del comité de seguridad y salud en el trabajo o al supervisor de seguridad y salud en el trabajo.'
                   ],
                   'capacitacion-7' => [
                       'id' => 'capacitacion-7',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'Las capacitaciones están documentadas.'
                   ],
                   'capacitacion-8' => [
                       'id' => 'capacitacion-8',
                       'name' => 'Capacitación',
                       'category' => 'implementacion',
                       'description' => 'Se han realizado capacitaciones de seguridad y salud en el trabajo:
                       -Al momento de la contratación, cualquiera sea la modalidad o duración.
                       -Durante el desempeño de la labor.
                       -Específica en el puesto de trabajo o en la función que cada trabajador desempeña, cualquiera que sea la naturaleza del vínculo, modalidad o duración de su contrato.
                       -Cuando se produce cambios en las funciones que desempeña el trabajador.
                       -Cuando se produce cambios en las tecnologías o en los equipos de trabajo.
                       -En las medidas que permitan la adaptación a la evolución de los riesgos y la prevención de nuevos riesgos.
                       -Para la actualización periódica de los conocimientos.
                       -Utilización y mantenimiento preventivo de las maquinarias y equipos.
                       -Uso apropiado de los materiales peligrosos.'
                   ],

                   'medidas_prevencion-1' => [
                       'id' => 'medidas_prevencion-1',
                       'name' => 'Medidas de prevención',
                       'category' => 'implementacion',
                       'description' => 'Las medidas de prevención y protección se aplican en el orden de prioridad:
                       -Eliminación de los peligros y riesgos.
                       -Tratamiento, control o aislamiento de los peligros y riesgos, adoptando medidas técnicas o administrativas.
                       -Minimizar los peligros y riesgos, adoptando sistemas de trabajo seguro que incluyan disposiciones administrativas de control.
                       -Programar la sustitución progresiva y en la brevedad posible, de los procedimientos, técnicas, medios, sustancias y productos peligrosos por aquellos que produzcan un menor riesgo o ningún riesgo para el trabajador.
                       -En último caso, facilitar equipos de protección personal adecuados, asegurándose que los trabajadores los utilicen y conserven en forma correcta.'
                   ],


                   'emergencias-1' => [
                       'id' => 'emergencias-1',
                       'name' => 'Preparación y respuestas ante emergencias',
                       'category' => 'implementacion',
                       'description' => 'La empresa, entidad pública o privada ha elaborado planes y procedimientos para enfrentar y responder ante situaciones de emergencias.'
                   ],
                   'emergencias-2' => [
                       'id' => 'emergencias-2',
                       'name' => 'Preparación y respuestas ante emergencias',
                       'category' => 'implementacion',
                       'description' => 'Se tiene organizada la brigada para actuar en caso de: incendios, primeros auxilios, evacuación.'
                   ],
                   'emergencias-3' => [
                       'id' => 'emergencias-3',
                       'name' => 'Preparación y respuestas ante emergencias',
                       'category' => 'implementacion',
                       'description' => 'La empresa, entidad pública o privada revisa los planes y procedimientos ante situaciones de emergencias en forma periódica.'
                   ],
                   'emergencias-4' => [
                       'id' => 'emergencias-4',
                       'name' => 'Preparación y respuestas ante emergencias',
                       'category' => 'implementacion',
                       'description' => 'El empleador ha dado las instrucciones a los trabajadores para que en caso de un peligro grave e inminente puedan interrumpir sus labores y/o evacuar la zona de riesgo.'
                   ],
                   'contratistas-1' => [
                       'id' => 'contratistas-1',
                       'name' => 'Contratistas, Subcontratistas, empresa, entidad pública o privada, de servicios y cooperativas',
                       'category' => 'implementacion',
                       'description' => 'El empleador que asume el contrato principal en cuyas instalaciones desarrollan actividades, trabajadores de contratistas, subcontratistas, empresas especiales de servicios y cooperativas de trabajadores, garantiza:
                       -La coordinación de la gestión en prevención de riesgos laborales.
                       -La seguridad y salud de los trabajadores.
                       -La verificación de la contratación de los seguros de acuerdo a ley por cada empleador.
                       -La vigilancia del cumplimiento de la normatividad en materia de seguridad y salud en el trabajo por parte de la empresa, entidad pública o privada que destacan su personal.'
                   ],
                   'contratistas-2' => [
                       'id' => 'contratistas-2',
                       'name' => 'Contratistas, Subcontratistas, empresa, entidad pública o privada, de servicios y cooperativas',
                       'category' => 'implementacion',
                       'description' => 'Todos los trabajadores tienen el mismo nivel de protección en materia de seguridad y salud en el trabajo sea que tengan vínculo laboral con el empleador o con contratistas, subcontratistas, empresa especiales de servicios o cooperativas de trabajadores.'
                   ],
                   'consulta-1' => [
                       'id' => 'consulta-1',
                       'name' => 'Consulta y comunicación',
                       'category' => 'implementacion',
                       'description' => 'Los trabajadores han participado en:
                       -La consulta, información y capacitación en seguridad y salud en el trabajo.
                       -La elección de sus representantes ante el Comité de seguridad y salud en el trabajo.
                       -La conformación del Comité de seguridad y salud en el trabajo.
                       -El reconocimiento de sus representantes por parte del empleador.'
                   ],
                   'consulta-2' => [
                       'id' => 'consulta-2',
                       'name' => 'Consulta y comunicación',
                       'category' => 'implementacion',
                       'description' => 'Los trabajadores han sido consultados ante los cambios realizados en las operaciones, procesos y organización del trabajo que repercuta en su seguridad y salud.'
                   ],
                   'consulta-3' => [
                       'id' => 'consulta-3',
                       'name' => 'Consulta y comunicación',
                       'category' => 'implementacion',
                       'description' => 'Existe procedimientos para asegurar que las informaciones pertinentes lleguen a los trabajadores correspondientes de la organización.'
                   ],
               ]
           ],

           'evaluacion' => [
               'id' => 'evaluacion',
               'name' => 'Evaluación normativa',
               'indicators' => [
                   'requisitos-1' => [
                       'id' => 'requisitos-1',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'La empresa, entidad pública o privada tiene un procedimiento para identificar, acceder y monitorear el cumplimiento de la normatividad aplicable al sistema de gestión de seguridad y salud en el trabajo y se mantiene actualizada.'
                   ],
                   'requisitos-2' => [
                       'id' => 'requisitos-2',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'La empresa, entidad pública o privada con 20 o más trabajadores ha elaborado su Reglamento Interno de Seguridad y Salud en el Trabajo.'
                   ],
                   'requisitos-3' => [
                       'id' => 'requisitos-3',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'La empresa, entidad pública o privada con 20 o más trabajadores tiene un Libro del Comité de Seguridad y Salud en el Trabajo (Salvo que una norma sectorial no establezca un número mínimo inferior).'
                   ],
                   'requisitos-4' => [
                       'id' => 'requisitos-4',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'Los equipos a presión que posee la empresa entidad pública o privada tienen su libro de servicio autorizado por el MTPE.'
                   ],
                   'requisitos-5' => [
                       'id' => 'requisitos-5',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'El empleador adopta las medidas necesarias y oportunas, cuando detecta que la utilización de ropas y/o equipos de trabajo o de protección personal representan riesgos específicos para la seguridad y salud de los trabajadores.'
                   ],
                   'requisitos-6' => [
                       'id' => 'requisitos-6',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'El empleador toma medidas que eviten las labores peligrosas a trabajadoras en periodo de embarazo o lactancia conforme a ley.'
                   ],
                   'requisitos-7' => [
                       'id' => 'requisitos-7',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'El empleador no emplea a niños, ni adolescentes en actividades peligrosas.'
                   ],
                   'requisitos-8' => [
                       'id' => 'requisitos-8',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'El empleador evalúa el puesto de trabajo que va a desempeñar un adolescente trabajador previamente a su incorporación laboral a fin de determinar la naturaleza, el grado y la duración de la exposición al riesgo, con el objeto de adoptar medidas preventivas necesarias.'
                   ],
                   'requisitos-9' => [
                       'id' => 'requisitos-9',
                       'name' => 'Requisitos legales y de otro tipo',
                       'category' => 'evaluacion',
                       'description' => 'La empresa, entidad pública o privada dispondrá lo necesario para que:
                       -Las máquinas, equipos, sustancias, productos o útiles de trabajo no constituyan una fuente de peligro.
                       -Se proporcione información y capacitación sobre la instalación, adecuada utilización y mantenimiento preventivo de las maquinarias y equipos.
                       -Se proporcione información y capacitación para el uso apropiado de los materiales peligrosos.
                       -Las instrucciones, manuales, avisos de peligro u otras medidas de precaución colocadas en los equipos y maquinarias estén traducido al castellano.
                       -Las informaciones relativas a las máquinas, equipos, productos, sustancias o útiles de trabajo son comprensibles para los trabajadores.
                       
                       Los trabajadores cumplen con:
                       -Las normas, reglamentos e instrucciones de los programas de seguridad y salud en el trabajo que se apliquen en el lugar de trabajo y con las instrucciones que les impartan sus superiores jerárquicos directos.
                       -Usar adecuadamente los instrumentos y materiales de trabajo, así como los equipos de protección personal y colectiva.
                       -No operar o manipular equipos, maquinarias, herramientas u otros elementos para los cuales no hayan sido autorizados y, en caso de ser necesario, capacitados.
                       -Cooperar y participar en el proceso de investigación de los accidentes de trabajo, incidentes peligrosos, otros incidentes y las enfermedades ocupacionales cuando la autoridad competente lo requiera.
                       -Velar por el cuidado integral individual y colectivo, de su salud física y mental.
                       -Someterse a exámenes médicos obligatorios.
                       -Participar en los organismos paritarios de seguridad y salud en el trabajo.
                       -Comunicar al empleador situaciones que ponga o pueda poner en riesgo su seguridad y salud y/o las instalaciones físicas.
                       -Reportar a los representantes de seguridad de forma inmediata, la ocurrencia de cualquier accidente de trabajo, incidente peligroso o incidente.
                       -Concurrir a la capacitación y entrenamiento sobre seguridad y salud en el trabajo.'
                   ],
               ]
           ],

           'verificacion' => [
               'id' => 'verificacion',
               'name' => 'Verificación',
               'indicators' => [
                   'supervision-1' => [
                       'id' => 'supervision-1',
                       'name' => 'Supervisión monitoreo y seguimiento de desempeño',
                       'category' => 'verificacion',
                       'description' => 'La vigilancia y control de la seguridad y salud en el trabajo permite evaluar con regularidad los resultados logrados en materia de seguridad y salud en el trabajo.'
                   ],
                   'supervision-2' => [
                       'id' => 'supervision-2',
                       'name' => 'Supervisión monitoreo y seguimiento de desempeño',
                       'category' => 'verificacion',
                       'description' => 'La supervisión permite:
                       -Identificar las fallas o deficiencias en el sistema de gestión de la seguridad y salud en el trabajo.
                       -Adoptar las medidas preventivas y correctivas.'
                   ],
                   'supervision-3' => [
                       'id' => 'supervision-3',
                       'name' => 'Supervisión monitoreo y seguimiento de desempeño',
                       'category' => 'verificacion',
                       'description' => 'El monitoreo permite la medición cuantitativa y cualitativa apropiadas.'
                   ],
                   'supervision-4' => [
                       'id' => 'supervision-4',
                       'name' => 'Supervisión monitoreo y seguimiento de desempeño',
                       'category' => 'verificacion',
                       'description' => 'Se monitorea el grado de cumplimiento de los objetivos de la seguridad y salud en el trabajo.'
                   ],
                   'salud-1' => [
                       'id' => 'salud-1',
                       'name' => 'Salud en el trabajo',
                       'category' => 'verificacion',
                       'description' => 'El empleador realiza exámenes médicos antes, durante y al término de la relación laboral a los trabajadores (incluyendo a los adolescentes).'
                   ],
                   'salud-2' => [
                       'id' => 'salud-2',
                       'name' => 'Salud en el trabajo',
                       'category' => 'verificacion',
                       'description' => 'Los trabajadores son informados:
                       -A título grupal, de las razones para los exámenes de salud ocupacional.
                       -A título personal, sobre los resultados de los informes médicos relativos a la evaluación de su salud.
                       -Los resultados de los exámenes médicos no son pasibles de uso para ejercer discriminación.'
                   ],
                   'salud-3' => [
                       'id' => 'salud-3',
                       'name' => 'Salud en el trabajo',
                       'category' => 'verificacion',
                       'description' => 'Los resultados de los exámenes médicos son considerados para tomar acciones preventivas o correctivas al respecto.'
                   ],
                   'accidentes_incidentes-1' => [
                       'id' => 'accidentes_incidentes-1',
                       'name' => 'Accidentes, incidentes peligrosos e incidentes, no conformidad, acción correctiva y preventiva',
                       'category' => 'verificacion',
                       'description' => 'El empleador notifica al Ministerio de Trabajo y Promoción del Empleo los accidentes de trabajo mortales dentro de las 24 horas de ocurridos.'
                   ],
                   'accidentes_incidentes-2' => [
                       'id' => 'accidentes_incidentes-2',
                       'name' => 'Accidentes, incidentes peligrosos e incidentes, no conformidad, acción correctiva y preventiva',
                       'category' => 'verificacion',
                       'description' => 'El empleador notifica al Ministerio de Trabajo y Promoción del Empleo, dentro de las 24 horas de producidos, los incidentes peligrosos que han puesto en riesgo la salud y la integridad física de los trabajadores y/o a la población.'
                   ],
                   'accidentes_incidentes-3' => [
                       'id' => 'accidentes_incidentes-3',
                       'name' => 'Accidentes, incidentes peligrosos e incidentes, no conformidad, acción correctiva y preventiva',
                       'category' => 'verificacion',
                       'description' => 'Se implementan las medidas correctivas propuestas en los registros de accidentes de trabajo, incidentes peligrosos y otros incidentes.'
                   ],
                   'accidentes_incidentes-4' => [
                       'id' => 'accidentes_incidentes-4',
                       'name' => 'Accidentes, incidentes peligrosos e incidentes, no conformidad, acción correctiva y preventiva',
                       'category' => 'verificacion',
                       'description' => 'Se implementan las medidas correctivas producto de la no conformidad hallada en las auditorías de seguridad y salud en el trabajo.'
                   ],
                   'accidentes_incidentes-5' => [
                       'id' => 'accidentes_incidentes-5',
                       'name' => 'Accidentes, incidentes peligrosos e incidentes, no conformidad, acción correctiva y preventiva',
                       'category' => 'verificacion',
                       'description' => 'Se implementan medidas preventivas de seguridad y salud en el trabajo.'
                   ],
                   //Seguir aqui con el ultimo de la pagina 10

                   'investigacion_accidentes-1' => [
                       'id' => 'investigacion_accidentes-1',
                       'name' => 'Investigación de accidentes y enfermedades ocupacionales',
                       'category' => 'verificacion',
                       'description' => 'El empleador ha realizado las investigaciones de accidentes de trabajo, enfermedades ocupacionales e incidentes peligrosos, y ha comunicado a la autoridad administrativa de trabajo, indicando las medidas correctivas y preventivas adoptadas.'
                   ],
                   'investigacion_accidentes-2' => [
                       'id' => 'investigacion_accidentes-2',
                       'name' => 'Investigación de accidentes y enfermedades ocupacionales',
                       'category' => 'verificacion',
                       'description' => 'Se investiga los accidentes de trabajo, enfermedades ocupacionales e incidentes peligrosos para:
                       -Determinar las causas e implementar las medidas correctivas.
                       -Comprobar la eficacia de las medidas de seguridad y salud vigentes al momento de hecho.
                       -Determinar la necesidad modificar dichas medidas.'
                   ],
                   'investigacion_accidentes-3' => [
                       'id' => 'investigacion_accidentes-3',
                       'name' => 'Investigación de accidentes y enfermedades ocupacionales',
                       'category' => 'verificacion',
                       'description' => 'Se toma medidas correctivas para reducir las consecuencias de accidentes.'
                   ],
                   'investigacion_accidentes-4' => [
                       'id' => 'investigacion_accidentes-4',
                       'name' => 'Investigación de accidentes y enfermedades ocupacionales',
                       'category' => 'verificacion',
                       'description' => 'Se ha documentado los cambios en los procedimientos como consecuencia de las acciones correctivas.'
                   ],
                   'investigacion_accidentes-5' => [
                       'id' => 'investigacion_accidentes-5',
                       'name' => 'Investigación de accidentes y enfermedades ocupacionales',
                       'category' => 'verificacion',
                       'description' => 'El trabajador ha sido transferido en caso de accidente de trabajo o enfermedad ocupacional a otro puesto que implique menos riesgo.'
                   ],
                   'control_operaciones-1' => [
                       'id' => 'control_operaciones-1',
                       'name' => 'Control de las operaciones',
                       'category' => 'verificacion',
                       'description' => 'La empresa, entidad pública o privada ha identificado las operaciones y actividades que están asociadas con riesgos donde las medidas de control necesitan ser aplicadas.'
                   ],
                   'control_operaciones-2' => [
                       'id' => 'control_operaciones-2',
                       'name' => 'Control de las operaciones',
                       'category' => 'verificacion',
                       'description' => 'La empresa, entidad pública o privada ha establecido procedimientos para el diseño del lugar de trabajo, procesos operativos, instalaciones, maquinarias y organización del trabajo que incluye la adaptación a las capacidades humanas a modo de reducir los riesgos en sus fuentes.'
                   ],
                   'gestion_cambio-1' => [
                       'id' => 'gestion_cambio-1',
                       'name' => 'Gestión del cambio',
                       'category' => 'verificacion',
                       'description' => 'Se ha evaluado las medidas de seguridad debido a cambios internos, método de trabajo, estructura organizativa y cambios externos normativos, conocimientos en el campo de la seguridad, cambios tecnológicos, adaptándose las medidas de prevención antes de introducirlos.'
                   ],
                   'auditorias-1' => [
                       'id' => 'auditorias-1',
                       'name' => 'Auditorias',
                       'category' => 'verificacion',
                       'description' => 'Se cuenta con un programa de auditorías.'
                   ],
                   'auditorias-2' => [
                       'id' => 'auditorias-2',
                       'name' => 'Auditorias',
                       'category' => 'verificacion',
                       'description' => 'El empleador realiza auditorías internas periódicas para comprobar la adecuada aplicación del sistema de gestión de la seguridad y salud en el trabajo.'
                   ],
               ]
           ],

           'control' => [
               'id' => 'control',
               'name' => 'Control de información y documentos',
               'indicators' => [
                   'documentos-1' => [
                       'id' => 'documentos-1',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'La empresa, entidad pública o privada establece y mantiene información en medios apropiados para describir los componentes del sistema de gestión y su relación entre ellos.'
                   ],
                   'documentos-2' => [
                       'id' => 'documentos-2',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'Los procedimientos de la empresa, entidad pública o privada, en la gestión de la seguridad y salud en el trabajo, se revisan periódicamente.'
                   ],
                   'documentos-3' => [
                       'id' => 'documentos-3',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'El empleador establece y mantiene disposiciones y procedimientos para:
                       -Recibir, documentar y responder adecuadamente a las comunicaciones internas y externas relativas a la seguridad y salud en el trabajo.
                       -Garantizar la comunicación interna de la información relativa a la seguridad y salud en el trabajo entre los distintos niveles y cargos de la organización.
                       -Garantizar que las sugerencias de los trabajadores o de sus representantes sobre seguridad y salud en el trabajo se reciban y atiendan en forma oportuna y adecuada.'
                   ],
                   'documentos-4' => [
                       'id' => 'documentos-4',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'El empleador entrega adjunto a los contratos de trabajo las recomendaciones de seguridad y salud considerando los riesgos del centro de labores y los relacionados con el puesto o función del trabajador.'
                   ],
                   'documentos-5' => [
                       'id' => 'documentos-5',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'El empleador ha:
                       -Facilitado al trabajador una copia del reglamento interno de seguridad y salud en el trabajo.
                       -Capacitado al trabajador en referencia al contenido del reglamento interno de seguridad.
                       -Asegurado poner en práctica las medidas de seguridad y salud en el trabajo.
                       -Elaborado un mapa de riesgos del centro de trabajo y lo exhibe en un lugar visible.
                       -El empleador entrega al trabajador las recomendaciones de seguridad y salud en el trabajo considerando los riesgos del centro de labores y los relacionados con el puesto o función, el primer día de labores.'
                   ],
                   'documentos-6' => [
                       'id' => 'documentos-6',
                       'name' => 'Documentos',
                       'category' => 'control',
                       'description' => 'El empleador mantiene procedimientos para garantizan que:
                       -Se identifiquen, evalúen e incorporen en las especificaciones relativas a compras y arrendamiento financiero, disposiciones relativas al cumplimiento por parte de la organización de los requisitos de seguridad y salud.
                       -Se identifiquen las obligaciones y los requisitos tanto legales como de la propia organización en materia de seguridad y salud en el trabajo antes de la adquisición de bienes y servicios.
                       -Se adopten disposiciones para que se cumplan dichos requisitos antes de utilizar los bienes y servicios mencionados.'
                   ],
                   'control_documentacion-1' => [
                       'id' => 'control_documentacion-1',
                       'name' => 'Control de la documentación y de los datos',
                       'category' => 'control',
                       'description' => 'La empresa, entidad pública o privada establece procedimientos para el control de los documentos que se generen por esta lista de verificación.'
                   ],
                   'control_documentacion-2' => [
                       'id' => 'control_documentacion-2',
                       'name' => 'Control de la documentación y de los datos',
                       'category' => 'control',
                       'description' => 'Este control asegura que los documentos y datos:
                       -Puedan ser fácilmente localizados.
                       -Puedan ser analizados y verificados periódicamente.
                       -Están disponibles en los locales.
                       -Sean removidos cuando los datos sen obsoletos.
                       -Sean adecuadamente archivados.'
                   ],
                   'gestion_registros-1' => [
                       'id' => 'gestion_registros-1',
                       'name' => 'Gestión de los registros',
                       'category' => 'control',
                       'description' => 'El empleador ha implementado registros y documentos del sistema de gestión actualizados y a disposición del trabajador referido a:
                       -Registro de accidentes de trabajo, enfermedades ocupacionales, incidentes peligrosos y otros incidentes, en el que deben constar la investigación y las medidas correctivas.
                       -Registro de exámenes médicos ocupacionales.
                       -Registro del monitoreo de agentes físicos, químicos, biológicos, psicosociales y factores de riesgo disergonómicos.
                       -Registro de inspecciones internas de seguridad y salud en el trabajo.
                       -Registro de estadísticas de seguridad y salud.
                       -Registro de equipos de seguridad o emergencia.
                       -Registro de inducción, capacitación, entrenamiento y simulacros de emergencia.
                       -Registro de auditorías.'
                   ],
                   'gestion_registros-2' => [
                       'id' => 'gestion_registros-2',
                       'name' => 'Gestión de los registros',
                       'category' => 'control',
                       'description' => 'La empresa, entidad pública o privada cuenta con registro de accidente de trabajo y enfermedad ocupacional e incidentes peligrosos y otros incidentes ocurridos a:
                       -Sus trabajadores.
                       -Trabajadores de intermediación laboral y/o tercerización.
                       -Beneficiarios bajo modalidades formativas.
                       -Personal que presta servicios de manera independiente, desarrollando sus actividades total o parcialmente en las instalaciones de la empresa, entidad pública o privada.'
                   ],
                   'gestion_registros-3' => [
                       'id' => 'gestion_registros-3',
                       'name' => 'Gestión de los registros',
                       'category' => 'control',
                       'description' => 'Los registros mencionados son:
                       -Legibles e identificables.
                       -Permite su seguimiento.
                       -Son archivados y adecuadamente protegidos.'
                   ],
               ]
           ],

           'revision' => [
               'id' => 'revision',
               'name' => 'Revisión por la dirección',
               'indicators' => [
                   'mejora-1' => [
                       'id' => 'mejora-1',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'La alta dirección:
                       Revisa y analiza periódicamente el sistema de gestión para asegurar que es apropiada y efectiva.'
                   ],
                   'mejora-2' => [
                       'id' => 'mejora-2',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'Las disposiciones adoptadas por la dirección para la mejora continua del sistema de gestión de la seguridad y salud en el trabajo, deben tener en cuenta:
                       -Los objetivos de la seguridad y salud en el trabajo de la empresa, entidad pública o privada.
                       -Los resultados de la identificación de los peligros y evaluación de los riesgos.
                       -Los resultados de la supervisión y medición de la eficiencia.
                       -La investigación de accidentes, enfermedades ocupacionales, incidentes peligrosos y otros incidentes relacionados con el trabajo.
                       -Los resultados y recomendaciones de las auditorías y evaluaciones realizadas por la dirección de la empresa, entidad pública o privada.
                       -Las recomendaciones del Comité de seguridad y salud, o del Supervisor de seguridad y salud.
                       -Los cambios en las normas.
                       -La información pertinente nueva.
                       -Los resultados de los programas anuales de seguridad y salud en el trabajo.'
                   ],
                   'mejora-3' => [
                       'id' => 'mejora-3',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'La metodología de mejoramiento continuo considera:
                       -La identificación de las desviaciones de las prácticas y condiciones aceptadas como seguras.
                       -El establecimiento de estándares de seguridad.
                       -La medición y evaluación periódica del desempeño con respecto a los estándares de la empresa, entidad pública o privada.
                       -La corrección y reconocimiento del desempeño.'
                   ],
                   'mejora-4' => [
                       'id' => 'mejora-4',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'La investigación y auditorías permiten a la dirección de la empresa, entidad pública o privada lograr los fines previstos y determinar, de ser el caso, cambios en la política y objetivos del sistema de gestión de seguridad y salud en el trabajo.'
                   ],
                   'mejora-5' => [
                       'id' => 'mejora-5',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'La investigación de los accidentes, enfermedades ocupacionales, incidentes peligrosos y otros incidentes, permite identificar:
                       -Las causas inmediatas (actos y condiciones subestándares),
                       -Las causas básicas (factores personales y factores del trabajo),
                       -Deficiencia del sistema de gestión de la seguridad y salud en el trabajo, para la planificación de la acción correctiva pertinente.'
                   ],
                   'mejora-6' => [
                       'id' => 'mejora-6',
                       'name' => 'Gestión de la mejora continua',
                       'category' => 'revision',
                       'description' => 'El empleador ha modificado las medidas de prevención de riesgos laborales cuando resulten inadecuadas e insuficientes para garantizar la seguridad y salud de los trabajadores incluyendo al personal de los regímenes de intermediación y tercerización, modalidad formativa e incluso a los que prestan servicios de manera independiente, siempre que éstos desarrollen sus actividades total o parcialmente en las instalaciones de la empresa, entidad pública o privada durante el desarrollo de las operaciones.'
                   ],
               ]
           ],

       ];
    }


}