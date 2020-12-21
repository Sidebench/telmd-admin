<?php

namespace WFN\Admin\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormRenderBefore
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $form;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\WFN\Admin\Block\Widget\AbstractForm $form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }

}
