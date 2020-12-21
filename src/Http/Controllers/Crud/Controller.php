<?php
namespace WFN\Admin\Http\Controllers\Crud;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Alert;

abstract class Controller extends \WFN\Admin\Http\Controllers\Controller
{

    protected $adminRoute;

    protected $entity;

    public function __construct(Request $request)
    {
        parent::__construct();
        
        try {
            $this->_init($request);

            if(!$this->gridBlock instanceof \WFN\Admin\Block\Widget\AbstractGrid) {
                throw new \Exception();
            }

            if(!$this->formBlock instanceof \WFN\Admin\Block\Widget\AbstractForm) {
                throw new \Exception();
            }

            if(!$this->entity instanceof \Illuminate\Database\Eloquent\Model) {
                throw new \Exception();
            }

            if(empty($this->entityTitle) || empty($this->adminRoute)) {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            abort(404);
        }
    }

    protected abstract function _init(Request $request);

    public function index(Request $request)
    {
        return $this->gridBlock->render();
    }

    public function new()
    {
        return $this->formBlock->setInstance($this->entity)->render();
    }

    public function edit($id = false)
    {
        $this->entity = $this->entity->findOrFail($id);
        return $this->formBlock->setInstance($this->entity)->render();
    }

    public function delete($id)
    {
        try {
            $this->entity = $this->entity->findOrFail($id);
            $this->_beforeDelete();
            $this->entity->delete();
            Alert::addSuccess($this->entityTitle . ' has been deleted');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }
        return redirect()->route($this->adminRoute);
    }

    public function save(Request $request)
    {
        try {
            if($request->input('id')) {
                $this->entity = $this->entity->findOrFail($request->input('id'));
            }

            $this->validator($request->all())->validate();

            $data = $this->_prepareData($request->all());
            $this->entity->fill($data)->save();

            $this->_afterSave($request);

            Alert::addSuccess($this->entityTitle . ' has been saved');

        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Alert::addError($message);
                }
            }
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }
        return !$this->entity->id ? redirect()->route($this->adminRoute . '.new') : redirect()->route($this->adminRoute . '.edit', ['id' => $this->entity->id]);
    }

    protected function _beforeDelete()
    {
        return $this;
    }

    protected function _prepareData($data)
    {
        return $data;
    }

    protected function _afterSave(Request $request)
    {
        return $this;
    }

    protected abstract function validator(array $data);

}