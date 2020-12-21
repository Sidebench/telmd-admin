<?php
namespace WFN\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Settings;
use Storage;

class SettingsController extends Controller
{

    public function index()
    {
        return view('admin::settings.form');
    }

    public function save(Request $request)
    {
        try {
            $postData = $request->all();
            foreach(config('settings', []) as $groupIndex => $groudData) {
                foreach($groudData['fields'] as $index => $data) {
                    $value = '';
                    if(!empty($postData[$groupIndex][$index]['file']) && $postData[$groupIndex][$index]['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $postData[$groupIndex][$index]['file'];
                        $value = $this->_uploadImage($file);
                    } elseif($data['type'] == 'rows' && !empty($postData[$groupIndex][$index]) && is_array($postData[$groupIndex][$index])) {
                        $value = json_encode($postData[$groupIndex][$index]);
                    } elseif(isset($postData[$groupIndex][$index])) {
                        $value = $postData[$groupIndex][$index];
                    }

                    $config = Settings::getConfig($groupIndex . '/' . $index);
                    $config->setValue($value)->save();
                }
            }
            Alert::addSuccess('Settings has been saved');
        } catch (\Exception $e) {
            Alert::addError($e->getMessage());
        }
        return redirect()->route('admin.settings');
    }

    protected function _uploadImage($file)
    {
        $path = 'public' . DIRECTORY_SEPARATOR . \Settings::MEDIA_PATH;
        $fileName = $file->getClientOriginalName();
        if(Storage::disk('local')->exists($path . $fileName)) {
            $iterator = 1;
            while(Storage::disk('local')->exists($path . $fileName)) {
                $fileName = str_replace(
                    '.' . $file->getClientOriginalExtension(),
                    $iterator++ . '.' . $file->getClientOriginalExtension(),
                    $file->getClientOriginalName()
                );
            }
        }

        $file->storeAs($path, $fileName);
        return $fileName;
    }

}