<?php

namespace WFN\Admin\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GridRenderBefore
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $grid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\WFN\Admin\Block\Widget\AbstractGrid $grid)
    {
        $this->grid = $grid;
    }

    public function getGrid()
    {
        return $this->grid;
    }

}
