<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model {

	public $table = 'media';

    public $timestamps = false;

    public function delete()
    {
        switch($this->type){
            case 'image':
                $image_local_path = base_path() . "/storage/app/media/images/" . $this->file_name;
                if (file_exists($image_local_path)) {
                    unlink($image_local_path);
                }

                $presets_root_dir = base_path() . '/public/media/images/';

                $presets_list = scandir($presets_root_dir);

                foreach ($presets_list as $preset_dir) {
                    if (in_array($preset_dir, ['.', '..'])) {
                        continue;
                    }

                    $media_file_full_path = $presets_root_dir . $preset_dir . '/' . $this->file_name;

                    if (!file_exists($media_file_full_path)) {
                        continue;
                    }

                    unlink($media_file_full_path);
                }

                break;
        }

        parent::delete();
    }

}
