<?php
namespace PHPSTL\Handler;

use PHPSTL\Model\Facet;
use PHPSTL\Model\Vertex;

class DimensionsHandler implements HandlerInterface
{
    private $stats = null;

    private function calcStat(Vertex $vertex)
    {
        if(is_null($this->stats)){
            $this->stats['min']['x'] = $this->stats['max']['x'] = $vertex->x();
            $this->stats['min']['y'] = $this->stats['max']['y'] = $vertex->y();
            $this->stats['min']['z'] = $this->stats['max']['z'] = $vertex->z();
        }else{
            $this->stats['min']['x'] = min($this->stats['min']['x'], $vertex->x());
            $this->stats['min']['y'] = min($this->stats['min']['y'], $vertex->y());
            $this->stats['min']['z'] = min($this->stats['min']['z'], $vertex->z());
            $this->stats['max']['x'] = max($this->stats['max']['x'], $vertex->x());
            $this->stats['max']['y'] = max($this->stats['max']['y'], $vertex->y());
            $this->stats['max']['z'] = max($this->stats['max']['z'], $vertex->z());
        }
    }

    public function onModelName($modelName){}

    public function onFacet(Facet $facet)
    {
        for($i=1; $i<=3; $i++){
            $fnName = 'v'.$i;
            $this->calcStat($facet->$fnName());
        }
    }

    public function result()
    {
        return [
            'length' => $this->stats['max']['x'] - $this->stats['min']['x'],
            'width' => $this->stats['max']['y'] - $this->stats['min']['y'],
            'height' => $this->stats['max']['z'] - $this->stats['min']['z'],
        ];
    }
}