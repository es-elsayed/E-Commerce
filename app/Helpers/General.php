<?php
function get_languages()
{
    return App\Models\Language::active()->selection()->get();
}
function get_default_language()
{
    return Illuminate\Support\Facades\Config::get('app.locale');
}
function upload_image($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'assets/images/' . $folder . '/' . $filename;
    return $path;
}
