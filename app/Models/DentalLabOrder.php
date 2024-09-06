<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalLabOrder extends Model
{
    use HasFactory;

    protected $table = 'dental_lab_order';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'lab_id',
        'sending_date',
        'returning_date',
        'time',

        // ZIRCONIA Section
        'zirconia_mono',
        'zirconia_layered',
        'zirconia_non_pre_veneers',
        'zirconia_veneers',
        'zirconia_crown',
        'zirconia_bridges',

        'shade_main_1',
        'shade_left_1_1',
        'shade_left_1_2',
        'shade_left_1_3',
        'shade_right_1_1',
        'shade_right_1_2',
        'shade_right_1_3',
        'shade_main_2',
        'shade_left_2_1',
        'shade_left_2_2',
        'shade_left_2_3',
        'shade_right_2_1',
        'shade_right_2_2',
        'shade_right_2_3',
        'shade_right_2_4',
        // Shades
        'shade_main_1',
        'shade_left_1_1',
        'shade_left_1_2',
        'shade_left_1_3',
        'shade_right_1_1',
        'shade_right_1_2',
        'shade_main_2',
        'shade_left_2_1',
        'shade_left_2_2',
        'shade_left_2_3',
        'shade_right_2_1',
        'shade_right_2_2',

        // Shade Details
        'shade_d_top_8',
        'shade_d_top_7',
        'shade_d_top_6',
        'shade_d_top_5',
        'shade_d_top_4',
        'shade_d_top_3',
        'shade_d_top_2',
        'shade_d_top_1',
        'shade_d_bottom_1',
        'shade_d_bottom_2',
        'shade_d_bottom_3',
        'shade_d_bottom_4',
        'shade_d_bottom_5',
        'shade_d_bottom_6',
        'shade_d_bottom_7',
        'shade_d_bottom_8',
        'shade_m_top_8',
        'shade_m_top_7',
        'shade_m_top_6',
        'shade_m_top_5',
        'shade_m_top_4',
        'shade_m_top_3',
        'shade_m_top_2',
        'shade_m_top_1',
        'shade_m_bottom_1',
        'shade_m_bottom_2',
        'shade_m_bottom_3',
        'shade_m_bottom_4',
        'shade_m_bottom_5',
        'shade_m_bottom_6',
        'shade_m_bottom_7',
        'shade_m_bottom_8',

        // E-MAX Section
        'e_max_milled',
        'e_max_pressed',
        'e_max_non_pre_veneers',
        'e_max_veneers',
        'e_max_crown',
        'e_max_bridges',

        // PFM Section
        'pfm_porcelain',
        'pfm_non_pres',
        'pfm_implant',
        'pfm_post_and_core',
        'pfm_crown',
        'pfm_bridges',

        // PEEK Section
        'peek_removable_partial_denture',
        'peek_fixed_prosthetic_framework',
        'peek_attachment_restorations',
        'peek_supported',
        'peek_screw',
        'peek_retained',
        'peek_implant',
        'peek_superstructures',

        // Removable Prosthetics Section
        'removable_diagnostic_wax_up',
        'removable_hybrid_denture',
        'removable_tooth_addition',
        'removable_over_denture',
        'removable_relining_hard_soft',
        'removable_veneers',
        'removable_flexible',
        'removable_crown',
        'removable_bridges',
        'removable_screw',
        'removable_implant',
        'removable_retained',

        // Items Sending Section
        'items_imp',
        'items_partial',
        'items_bite',
        'items_photo',
        'items_study_models',
        'items_shade_tab',
        'items_digital_impression',
        'items_furthers',
        'items_further',

        // Removable Appliance Section
        'appliance_ortho',
        'appliance_retainer',
        'appliance_night_guard',
        'appliance_occlusal_splint',
        'appliance_sheet_press_retainer',
        'appliance_wire',
        'appliance_hyrax',
        'appliance_tpa',
        'appliance_obturator',
        'appliance_space_maintainer',

        // Further Instructions
        'further_instructions',
        'instructions_from_lab',

        // Timestamps
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];

    public function doctor()
    {
        return $this->belongsTo(DoctorDetail::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(PatientDetail::class, 'patient_id');
    }
    public function lab()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
