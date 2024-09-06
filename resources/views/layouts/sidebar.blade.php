@php
    $c = Request::segment(1);
    $m = Request::segment(2);
    $roleName = Auth::user()->getRoleNames();
@endphp

<aside class="main-sidebar sidebar-light-info elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link sidebar-light-info">
        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $ApplicationSetting->item_name }}"
            id="custom-opacity-sidebar" class="brand-image">
        <span class="brand-text font-weight-light">{{ $ApplicationSetting->item_name }}</span>
    </a>
    <div class="sidebar">
        <?php
        if (Auth::user()->photo == null) {
            $photo = 'assets/images/profile/male.png';
        } else {
            $photo = Auth::user()->photo;
        }
        ?>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @canany(['dashboard-read'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link @if ($c == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ __('Dashboard') }}</p>
                        </a>
                    </li>
                @endcanany


                @canany(['doctor-detail-read', 'doctor-detail-create', 'doctor-detail-update', 'doctor-detail-delete'])
                    <li class="nav-item">
                        <a href="{{ route('doctor-details.index') }}"
                            class="nav-link @if ($c == 'doctor-details') active @endif">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>@lang('Doctors')</p>
                        </a>
                    </li>
                @endcanany

                @canany(['doctor-schedule-read', 'doctor-schedule-create', 'doctor-schedule-update',
                    'doctor-schedule-delete'])
                    <li class="nav-item">
                        <a href="{{ route('doctor-schedules.index') }}"
                            class="nav-link @if ($c == 'doctor-schedules') active @endif">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>@lang('Doctor Schedules')</p>
                        </a>
                    </li>
                @endcanany
                @canany(['patient-detail-read', 'patient-detail-create', 'patient-detail-update',
                    'patient-detail-delete'])
                    <li class="nav-item has-treeview @if (
                        $c == 'patient-case-studies' ||
                            $c == 'patient-details' ||
                            $c == 'exam-investigations' ||
                            $c == 'patient-medical-histories' ||
                            $c == 'patient-dental-histories' ||
                            $c == 'patient-drug-histories' ||
                            $c == 'patient-social-histories' ||
                            $c == 'patient-treatment-plans' ||
                            $c == 'test-files') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if (
                            $c == 'patient-case-studies' ||
                                $c == 'patient-details' ||
                                $c == 'exam-investigations' ||
                                $c == 'patient-medical-histories' ||
                                $c == 'patient-dental-histories' ||
                                $c == 'patient-drug-histories' ||
                                $c == 'patient-social-histories' ||
                                $c == 'patient-treatment-plans' ||
                                $c == 'test-files') active @endif">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>
                                @lang('Patients')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @canany(['patient-detail-read', 'patient-detail-create', 'patient-detail-update',
                                'patient-detail-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-details.index') }}"
                                        class="nav-link @if ($c == 'patient-details') active @endif">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>@lang('View All Patients')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-case-studies-read', 'patient-case-studies-create',
                                'patient-case-studies-update', 'patient-case-studies-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-case-studies.index') }}"
                                        class="nav-link @if ($c == 'patient-case-studies') active @endif">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>@lang('Patient Case Studies')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-medical-histories-read', 'patient-medical-histories-create',
                                'patient-medical-histories-update', 'patient-medical-histories-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-medical-histories.index') }}"
                                        class="nav-link @if ($c == 'patient-medical-histories') active @endif">
                                        <i class="nav-icon fas fa-book-medical"></i>
                                        <p>@lang('Medical History')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-dental-histories-read', 'patient-dental-histories-create',
                                'patient-dental-histories-update', 'patient-dental-histories-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-dental-histories.index') }}"
                                        class="nav-link @if ($c == 'patient-dental-histories') active @endif">
                                        <i class="nav-icon fas fa-tooth"></i>
                                        <p>@lang('Dental History')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-drug-histories-read', 'patient-drug-histories-create',
                                'patient-drug-histories-update', 'patient-drug-histories-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-drug-histories.index') }}"
                                        class="nav-link @if ($c == 'patient-drug-histories') active @endif">
                                        <i class="nav-icon fas fa-pills"></i>
                                        <p>@lang('Drug History')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-social-histories-read', 'patient-social-histories-create',
                                'patient-social-histories-update', 'patient-social-histories-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-social-histories.index') }}"
                                        class="nav-link @if ($c == 'patient-social-histories') active @endif">
                                        <i class="nav-icon fas fa-user-friends"></i>
                                        <p>@lang('Social History')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['exam-investigations-read', 'exam-investigations-create', 'exam-investigations-update',
                                'exam-investigations-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('exam-investigations.index') }}"
                                        class="nav-link @if ($c == 'exam-investigations') active @endif">
                                        <i class="nav-icon fas fa-tooth"></i>
                                        <p>@lang('Exam & Investigation')</p>
                                    </a>
                                </li>
                            @endcanany

                            @canany(['patient-treatment-plans-read', 'patient-treatment-plans-create',
                                'patient-treatment-plans-update', 'patient-treatment-plans-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('patient-treatment-plans.index') }}"
                                        class="nav-link @if ($c == 'patient-treatment-plans') active @endif">
                                        <i class="nav-icon fas fa-notes-medical"></i>
                                        <p>@lang('Treatment Plans')</p>
                                    </a>
                                </li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany

                @canany(['patient-appointment-read', 'patient-appointment-create', 'patient-appointment-update',
                    'patient-appointment-delete'])
                    <li class="nav-item">
                        <a href="{{ route('patient-appointments.index') }}"
                            class="nav-link @if ($c == 'patient-appointments') active @endif">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>@lang('Patient Appointments')</p>
                        </a>
                    </li>
                @endcanany

                @canany(['prescription-read', 'prescription-create', 'prescription-update', 'prescription-delete'])
                    <li class="nav-item">
                        <a href="{{ route('prescriptions.index') }}"
                            class="nav-link @if ($c == 'prescriptions') active @endif">
                            <i class="nav-icon fas fa-file-prescription"></i>
                            <p>@lang('Prescription')</p>
                        </a>
                    </li>
                @endcanany

                @canany(['task-read', 'task-create', 'task-update', 'task-delete'])
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}"
                            class="nav-link @if ($c == 'tasks') active @endif">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>@lang('Tasks')</p>
                        </a>
                    </li>
                @endcanany

                @canany(['inventory-read', 'inventory-create', 'inventory-update', 'inventory-delete'])
                    <li class="nav-item">
                        <a href="{{ route('inventories.index') }}"
                            class="nav-link {{ $c == 'inventories' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>@lang('Inventory')</p>
                        </a>
                    </li>
                @endcanany


                @canany(['insurance-providers-delete'])
                    <li class="nav-item">
                        <a href="{{ route('insurance-providers.index') }}"
                            class="nav-link @if ($c == 'insurance-providers') active @endif">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>@lang('Insurance Providers')</p>
                        </a>
                    </li>
                @endcanany


                @canany(['dropdown-read', 'dropdown-create', 'dropdown-update', 'dropdown-delete'])
                    <li class="nav-item has-treeview @if (
                        $c == 'dd-blood-groups' ||
                            $c == 'dd-procedures' ||
                            $c == 'dd-medicine' ||
                            $c == 'subcategories' ||
                            $c == 'items' ||
                            $c == 'categories' ||
                            $c == 'dd-social-history' ||
                            $c == 'dd-medical-history' ||
                            $c == 'dd-procedure-categories' ||
                            $c == 'dd-dental-history' ||
                            $c == 'marital-statuses' ||
                            $c == 'dd-drug-history' ||
                            $c == 'appointment-statuses' ||
                            $c == 'dd-investigations' ||
                            $c == 'dd-treatment-plans' ||
                            $c == 'dd-examinations' ||
                            $c == 'dd-diagnoses' ||
                            $c == 'dd-task-action' ||
                            $c == 'dd-task-status' ||
                            $c == 'dd-task-type' ||
                            $c == 'dd-task-priority' ||
                            $c == 'dd-medicine-types' ||
                            $c == 'chief-complaints' ||
                            $c == 'extra-orals' ||
                            $c == 'intra-orals' ||
                            $c == 'soft-tissues'  || 
                            $c == 'hard-tissues'  
                               ) menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if (
                            $c == 'chief-complaints' ||
                            $c == 'dd-blood-groups' ||
                                $c == 'dd-procedures' ||
                                $c == 'dd-medicine' ||
                                $c == 'dd-diagnosis' ||
                                $c == 'subcategories' ||
                                $c == 'items' ||
                                $c == 'categories' ||
                                $c == 'dd-social-history' ||
                                $c == 'dd-procedure-categories' ||
                                $c == 'dd-dental-history' ||
                                $c == 'dd-medical-history' ||
                                $c == 'dd-examinations' ||
                                $c == 'appointment-statuses' ||
                                $c == 'dd-investigations' ||
                                $c == 'dd-drug-history' ||
                                $c == 'dd-treatment-plans' ||
                                $c == 'marital-statuses' ||
                                $c == 'dd-diagnoses' ||
                                $c == 'dd-task-priority' ||
                                $c == 'dd-task-action' ||
                                $c == 'dd-task-status' ||
                                $c == 'dd-task-type' ||
                                $c == 'extra-orals' ||
                                $c == 'soft-tissues'  ||
                                $c == 'hard-tissues' ||
                                $c == 'dd-medicine-types' || $c == 'intra-orals') active @endif">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                @lang('Dropdowns')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('hard-tissues.index') }}"
                                    class="nav-link @if ($c == 'hard-tissues') active @endif">
                                    <i class="nav-icon fas fa-bone"></i> <!-- Bone icon for Hard Tissues -->
                                    <p>@lang('Hard Tissues')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('soft-tissues.index') }}"
                                    class="nav-link @if ($c == 'soft-tissues') active @endif">
                                    <i class="nav-icon fas fa-venus-double"></i> <!-- Venus double icon for Soft Tissues -->
                                    <p>@lang('Soft Tissues')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('intra-orals.index') }}"
                                    class="nav-link @if ($c == 'intra-orals') active @endif">
                                    <i class="nav-icon fas fa-smile"></i> <!-- Smile icon for Intra Orals -->
                                    <p>@lang('Intra Orals')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('extra-orals.index') }}"
                                    class="nav-link @if ($c == 'extra-orals') active @endif">
                                    <i class="nav-icon fas fa-user-md"></i> <!-- User doctor icon for Extra Orals -->
                                    <p>@lang('Extra Orals')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chief-complaints.index') }}"
                                    class="nav-link @if ($c == 'chief-complaints') active @endif">
                                    <i class="nav-icon fas fa-exclamation-circle"></i> <!-- Exclamation circle icon for Chief Complaints -->
                                    <p>@lang('Chief Complaints')</p>
                                </a>
                            </li>
                            

                            <li class="nav-item">
                                <a href="{{ route('dd-blood-groups.index') }}"
                                    class="nav-link @if ($c == 'dd-blood-groups') active @endif">
                                    <i class="nav-icon fas fa-tint"></i>
                                    <p>@lang('Blood Groups')</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('marital-statuses.index') }}"
                                    class="nav-link @if ($c == 'marital-statuses') active @endif">
                                    <i class="nav-icon fas fa-heart"></i>
                                    <p>@lang('Marital Status')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-medicine-types.index') }}"
                                    class="nav-link @if ($c == 'dd-medicine-types') active @endif">
                                    <i class="nav-icon fas fa-pills"></i>
                                    <p>@lang('Medicine Types')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('appointment-statuses.index') }}"
                                    class="nav-link @if ($c == 'appointment-statuses') active @endif">
                                    <i class="nav-icon fas fa-calendar-check"></i>
                                    <p>@lang('Appointment Status')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-treatment-plans.index') }}"
                                    class="nav-link @if ($c == 'dd-treatment-plans') active @endif">
                                    <i class="nav-icon fas fa-notes-medical"></i>
                                    <p>@lang('Treatment Plan')</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('dd-examinations.index') }}"
                                    class="nav-link @if ($c == 'dd-examinations') active @endif">
                                    <i class="nav-icon fas fa-stethoscope"></i>
                                    <p>@lang('Examination Plan')</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('dd-investigations.index') }}"
                                    class="nav-link @if ($c == 'dd-investigations') active @endif">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>@lang('Investigations')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}"
                                    class="nav-link @if ($c == 'categories') active @endif">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>@lang('Category')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subcategories.index') }}"
                                    class="nav-link @if ($c == 'subcategories') active @endif">
                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>@lang('Sub Categories')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('items.index') }}"
                                    class="nav-link @if ($c == 'items') active @endif">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>@lang('Items')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-medical-history.index') }}"
                                    class="nav-link @if ($c == 'dd-medical-history') active @endif">
                                    <i class="nav-icon fas fa-notes-medical"></i>
                                    <p>@lang('Medical History')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-social-history.index') }}"
                                    class="nav-link @if ($c == 'dd-social-history') active @endif ">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>@lang('Social History')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-drug-history.index') }}"
                                    class="nav-link @if ($c == 'dd-drug-history') active @endif ">
                                    <i class="nav-icon fas fa-capsules"></i>
                                    <p>@lang('Drug History')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-dental-history.index') }}"
                                    class="nav-link @if ($c == 'dd-dental-history') active @endif ">
                                    <i class="nav-icon fas fa-tooth"></i>
                                    <p>@lang('Dental History')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-procedure-categories.index') }}"
                                    class="nav-link @if ($c == 'dd-procedure-categories') active @endif ">
                                    <i class="nav-icon fas fa-folder-plus"></i>
                                    <p>@lang('Procedure Category')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-procedures.index') }}"
                                    class="nav-link @if ($c == 'dd-procedures') active @endif ">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>@lang('Procedures')</p>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-medicine.index') }}"
                                    class="nav-link @if ($c == 'dd-medicine') active @endif ">
                                    <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                                    <p>@lang('Medicine')</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                            <a href="{{ route('dd-medicine-types.index') }}"
                                class="nav-link @if ($c == 'dd-medicine-types') active @endif ">
                                <i class="nav-icon fas fa-pills"></i>
                                <p>@lang('Medicine types')</p>
                            </a>
                        </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('dd-diagnoses.index') }}"
                                    class="nav-link @if ($c == 'dd-diagnoses') active @endif ">
                                    <i class="nav-icon fas fa-diagnoses"></i>
                                    <p>@lang('Diagnosis')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-task-priority.index') }}"
                                    class="nav-link @if ($c == 'dd-task-priority') active @endif ">
                                    <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                                    <p>@lang('Task Priority')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-task-action.index') }}"
                                    class="nav-link @if ($c == 'dd-task-action') active @endif ">
                                    <i class="nav-icon fas fa-pills"></i>
                                    <p>@lang('Task Action ')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-task-status.index') }}"
                                    class="nav-link @if ($c == 'dd-task-status') active @endif ">
                                    <i class="nav-icon fas fa-diagnoses"></i>
                                    <p>@lang('Task Status')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dd-task-type.index') }}"
                                    class="nav-link @if ($c == 'dd-task-type') active @endif ">
                                    <i class="nav-icon fas fa-diagnoses"></i>
                                    <p>@lang('Task Type')</p>
                                </a>
                            </li>

                        </ul>


                    </li>
                @endcanany

                @canany(['lab-report-read', 'lab-report-create', 'lab-report-update', 'lab-report-delete',
                    'lab-report-template-read', 'lab-report-template-create', 'lab-report-template-update',
                    'lab-report-template-delete'])
                    <li class="nav-item has-treeview @if ($c == 'labs' || $c == 'lab-reports' || $c == 'lab-report-templates') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if ($c == 'labs' || $c == 'lab-reports' || $c == 'lab-report-templates') active @endif">
                            <i class="nav-icon fas fa-vial"></i>
                            <p>
                                @lang('Lab')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['labs-read', 'labs-create', 'labs-update', 'labs-delete'])
                            <li class="nav-item">
                                <a href="{{ route('labs.index') }}"
                                    class="nav-link @if ($c == 'labs') active @endif">
                                    <i class="nav-icon fa fa-medkit"></i>
                                    <p>@lang('Lab')</p>
                                </a>
                            </li>
                            @endcanany

                            @canany(['lab-report-read', 'lab-report-create', 'lab-report-update', 'lab-report-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('dental_lab_orders.index') }}"
                                        class="nav-link @if ($c == 'lab-reports') active @endif">
                                        <i class="nav-icon fas fa-vial"></i>
                                        <p>@lang('Lab Report')</p>
                                    </a>
                                </li>
                            @endcanany
                            {{-- @canany(['lab-report-template-read', 'lab-report-template-create', 'lab-report-template-update',
                                'lab-report-template-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('lab-report-templates.index') }}"
                                        class="nav-link @if ($c == 'lab-report-templates') active @endif">
                                        <i class="nav-icon fas fa-crop-alt"></i>
                                        <p>@lang('Lab Report Templates')</p>
                                    </a>
                                </li>
                            @endcanany --}}
                        </ul>
                    </li>
                @endcanany

                @canany(['account-header-read', 'account-header-create', 'account-header-update',
                    'account-header-delete', 'payment-read', 'payment-create', 'payment-update', 'payment-delete',
                    'invoice-read', 'invoice-create', 'invoice-update', 'invoice-delete', 'financial-report-read'])
                    <li class="nav-item has-treeview @if ($c == 'account-headers' || $c == 'invoices' || $c == 'payments' || $c == 'financial-reports' || $c == 'new-reports') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if ($c == 'account-headers' || $c == 'invoices' || $c == 'payments' || $c == 'financial-reports' || $c == 'new-reports') active @endif">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                @lang('Financial Activities')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['account-header-read', 'account-header-create', 'account-header-update',
                                'account-header-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('account-headers.index') }}"
                                        class="nav-link @if ($c == 'account-headers') active @endif ">
                                        <i class="fas fa-comment-dollar"></i>
                                        <p>@lang('Account Header')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['invoice-read', 'invoice-create', 'invoice-update', 'invoice-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('invoices.index') }}"
                                        class="nav-link @if ($c == 'invoices') active @endif ">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <p>@lang('Invoice')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['payment-read', 'payment-create', 'payment-update', 'payment-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('payments.index') }}"
                                        class="nav-link @if ($c == 'payments') active @endif ">
                                        <i class="fas fa-money-check"></i>
                                        <p>@lang('Expense')</p>
                                    </a>
                                </li>
                            @endcanany
                            {{-- @canany(['financial-report-read'])
                                <li class="nav-item">
                                    <a href="{{ route('financial-reports.index') }}"
                                        class="nav-link @if ($c == 'financial-reports') active @endif ">
                                        <i class="fas fa-folder-open"></i>
                                        <p>@lang('Report')</p>
                                    </a>
                                </li>
                            @endcanany --}}
                            {{-- @canany(['lab-report-read', 'lab-report-create', 'lab-report-update', 'lab-report-delete']) --}}
                            <li class="nav-item">
                                <a href="{{ route('new-reports.index') }}"
                                    class="nav-link @if ($c == 'new-reports') active @endif">
                                    <i class="fas fa-folder-open"></i>
                                    <p>@lang('Report')</p>
                                </a>
                            </li>
                            {{-- @endcanany --}}
                        </ul>
                    </li>
                @endcanany




                @canany(['role-read', 'role-create', 'role-update', 'role-delete', 'user-read', 'user-create',
                    'user-update', 'user-delete', 'smtp-read', 'smtp-create', 'smtp-update', 'smtp-delete', 'company-read',
                    'company-create', 'company-update', 'company-delete', 'currencies-read', 'currencies-create',
                    'currencies-update', 'currencies-delete', 'tax-rate-read', 'tax-rate-create', 'tax-rate-update',
                    'tax-rate-delete'])
                    <li class="nav-item has-treeview @if (
                        $c == 'roles' ||
                            $c == 'users' ||
                            $c == 'apsetting' ||
                            $c == 'smtp-configurations' ||
                            $c == 'general' ||
                            $c == 'currency' ||
                            $c == 'tax') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if (
                            $c == 'roles' ||
                                $c == 'users' ||
                                $c == 'apsetting' ||
                                $c == 'smtp-configurations' ||
                                $c == 'general' ||
                                $c == 'currency' ||
                                $c == 'tax') active @endif">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                                @lang('Settings')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['role-read', 'role-create', 'role-update', 'role-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link @if ($c == 'roles') active @endif ">
                                        <i class="fas fa-cube nav-icon"></i>
                                        <p>@lang('Role Management')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['user-read', 'user-create', 'user-update', 'user-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link @if ($c == 'users') active @endif ">
                                        <i class="fa fa-users nav-icon"></i>
                                        <p>@lang('User Management')</p>
                                    </a>
                                </li>
                            @endcanany
                            @if ($roleName['0'] = 'Super Admin')
                                @canany(['apsetting-read', 'apsetting-create', 'apsetting-update', 'apsetting-delete'])
                                    <li class="nav-item">
                                        <a href="{{ route('apsetting') }}"
                                            class="nav-link @if ($c == 'apsetting' && $m == null) active @endif ">
                                            <i class="fa fa-globe nav-icon"></i>
                                            <p>@lang('Application Settings')</p>
                                        </a>
                                    </li>
                                @endcanany
                            @endif

                            @canany(['company-read', 'company-create', 'company-update', 'company-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('general') }}"
                                        class="nav-link @if ($c == 'general') active @endif ">
                                        <i class="fas fa-align-left nav-icon"></i>
                                        <p>@lang('General Settings')</p>
                                    </a>
                                </li>
                            @endcanany



                        </ul>
                    </li>
                @endcanany
            </ul>
        </nav>
    </div>
</aside>
