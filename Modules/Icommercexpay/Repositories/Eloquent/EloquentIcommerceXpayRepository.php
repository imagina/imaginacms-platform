<?php

namespace Modules\Icommercexpay\Repositories\Eloquent;

use Illuminate\Support\Str;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercexpay\Repositories\IcommerceXpayRepository;

class EloquentIcommerceXpayRepository extends EloquentBaseRepository implements IcommerceXpayRepository
{
    /**
     * Update Payment Method
     */
    public function update($model, $data)
    {
        //Get data
        $requestimage = $data['mainimage'];

        // Delete attributes
        unset($data['mainimage']);

        // Image
        if (($requestimage == null) || (! empty($requestimage))) {
            $requestimage = $this->saveImage($requestimage, 'assets/icommercexpay/1.jpg');
        }
        $options['mainimage'] = $requestimage;

        // Extra data in Options
        $data['options'] = $options;

        $model->update($data);

        return $model;
    }

    /**
     * Save Image
     *
     * @param    $destination
     */
    public function saveImage($value, $destination_path)
    {
        $disk = 'publicmedia';

        //Defined return.
        if (ends_with($value, '.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if (config('asgard.iblog.config.watermark.activated')) {
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg', '80'));

            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg', '_mediumThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'), config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg', '80')
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg', '_smallThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'), config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg', '80')
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }
    }
}
