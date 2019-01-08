<?php
namespace PHPSTL\Handler;

use PHPSTL\Model\Facet;
use PHPSTL\Model\Vertex;

class AreaHandler implements HandlerInterface
{
    private $area;
    private $ref;

    public function onModelName($modelName)
    {}

    public function onFacet(Facet $facet)
    {
        if (!$this->ref) {
            $this->ref = $facet->v1();
        }

        $this->area += $facet->area();
    }

    public function result()
    {
        return $this->area;
    }
}