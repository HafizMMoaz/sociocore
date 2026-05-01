<?php

namespace App\Livewire\Settings;

use App\Helper\Files;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Models\GlobalSetting;

class ThemeSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $settings;
    public $themeColor;
    public $themeColorRgb;
    public $photo;
    public bool $showLogoText;
    public $upload_fav_icon_android_chrome_192;
    public $upload_fav_icon_android_chrome_512;
    public $upload_fav_icon_apple_touch_icon;
    public $upload_favicon_16;
    public $upload_favicon_32;
    public $favicon;
    public $savedImages;
    public $webmanifest;

    public function rules()
    {
        return [
            'photo' => 'nullable|image|max:1024',
            'upload_fav_icon_android_chrome_192' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'upload_fav_icon_android_chrome_512' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'upload_fav_icon_apple_touch_icon' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'upload_favicon_16' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'upload_favicon_32' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:ico|max:2048',
            'webmanifest' => 'nullable|file|mimes:json|max:2048',
            'themeColor' => 'required',
        ];
    }

    public function mount()
    {
        $this->themeColor = $this->settings->theme_hex;
        $this->themeColorRgb = $this->settings->theme_rgb;
        $this->showLogoText = $this->settings->show_logo_text;
        $this->savedImages = [
            'upload_fav_icon_android_chrome_192' => $this->settings->upload_fav_icon_android_chrome_192,
            'upload_fav_icon_android_chrome_512' => $this->settings->upload_fav_icon_android_chrome_512,
            'upload_fav_icon_apple_touch_icon' => $this->settings->upload_fav_icon_apple_touch_icon,
            'upload_favicon_16' => $this->settings->upload_favicon_16,
            'upload_favicon_32' => $this->settings->upload_favicon_32,
            'favicon' => $this->settings->favicon,
        ];
        $this->webmanifest = $this->settings->webmanifest;
    }

    public function submitForm()
    {
        $this->validate();

        $this->themeColorRgb = $this->hex2rgba($this->themeColor);

        $this->settings->theme_hex = $this->themeColor;
        $this->settings->theme_rgb = $this->themeColorRgb;
        $this->settings->show_logo_text = $this->showLogoText;
        $this->settings->save();


        if ($this->photo) {
            $this->settings->logo = Files::uploadLocalOrS3($this->photo, dir: 'logo', width: 150, height: 150);
        }

        $favicons = [
            'upload_fav_icon_android_chrome_192' => 'android-chrome-192x192.png',
            'upload_fav_icon_android_chrome_512' => 'android-chrome-512x512.png',
            'upload_fav_icon_apple_touch_icon' => 'apple-touch-icon.png',
            'upload_favicon_16' => 'favicon-16x16.png',
            'upload_favicon_32' => 'favicon-32x32.png',
            'favicon' => 'favicon.ico',
        ];

        $faviconBasePath = $this->settings->getFaviconBasePath();

        foreach (GlobalSetting::FAVICONS as $property => $filename) {
            if ($this->$property) {
                Files::deleteFile($this->settings->$property, $faviconBasePath);
                $this->settings->$property = Files::uploadLocalOrS3($this->$property, dir: $faviconBasePath, width: $filename['width'], height: $filename['height'], name: $filename['name']);
            }
        }

        if ($this->webmanifest && !$this->settings->webmanifest) {
            Files::deleteFile($this->settings->webmanifest, $faviconBasePath);
            $this->settings->webmanifest = Files::uploadLocalOrS3($this->webmanifest, dir: $faviconBasePath, name: 'site.webmanifest');
        }


        $this->settings->save();

        session()->forget(['society', 'timezone', 'currency']);

        $this->reset([
            'upload_fav_icon_android_chrome_192',
            'upload_fav_icon_android_chrome_512',
            'upload_fav_icon_apple_touch_icon',
            'upload_favicon_16',
            'upload_favicon_32',
            'favicon',
            'webmanifest',
        ]);
        $this->redirect(route('settings.index') . '?tab=theme', navigate: true);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function hex2rgba($color)
    {

        list($r, $g, $b) = sscanf($color, '#%02x%02x%02x');

        return $r . ', ' . $g . ', ' . $b;
    }

    public function deleteLogo()
    {
        if (is_null($this->settings->logo)) {
            return;
        }

        Files::deleteFile($this->settings->logo, 'logo');

        $this->settings->forceFill([
            'logo' => null,
        ])->save();

        session()->forget(['society']);

        $this->redirect(route('settings.index') . '?tab=theme', navigate: true);
    }

    public function render()
    {
        return view('livewire.settings.theme-settings');
    }
}
