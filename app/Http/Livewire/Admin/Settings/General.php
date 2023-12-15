<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Settings;
use Livewire\Component;

class General extends Component
{
    public $settings;

    public function mount()
    {
        $this->settings = [
            'tax_percentage' => Settings::where('key', 'tax_percentage')->value('values') ?? '',
            'minimum_room_rent_building_id_'.session('building_id') => Settings::where('key', 'minimum_room_rent_building_id_'.session('building_id'))->value('values') ?? '',
            'vat_registration_no_building_id_'.session('building_id') => Settings::where('key', 'vat_registration_no_building_id_'.session('building_id'))->value('values') ?? '',
            'extra_bed_charge' => Settings::where('key', 'extra_bed_charge')->value('values') ?? '',
        ];
    }

    public function save()
    {
        try {
            if (isset($this->settings['tax_percentage'])) {
                Settings::updateOrCreate(['key' => 'tax_percentage'], ['values' => $this->settings['tax_percentage']]);
            }
            if (isset($this->settings['minimum_room_rent_building_id_'.session('building_id')])) {
                Settings::updateOrCreate(['key' => 'minimum_room_rent_building_id_'.session('building_id')], ['values' => $this->settings['minimum_room_rent_building_id_'.session('building_id')]]);
            }
            if (isset($this->settings['vat_registration_no_building_id_'.session('building_id')])) {
                Settings::updateOrCreate(['key' => 'vat_registration_no_building_id_'.session('building_id')], ['values' => $this->settings['vat_registration_no_building_id_'.session('building_id')]]);
            }
            if (isset($this->settings['extra_bed_charge'])) {
                Settings::updateOrCreate(['key' => 'extra_bed_charge'], ['values' => $this->settings['extra_bed_charge']]);
            }
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully changed the settings values']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
