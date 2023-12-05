<?php

return [
    'name' => 'Admission',
    'long_name' => 'PENERIMAAN MAHASISWA BARU',

    'app' => [
    	'name' => 'Penerimaan Mahasiswa Baru',
    ],

    'head' => [
    	'title'	=> 'Penerimaan Mahasiswa Baru (PMB) '.env('APP_NAME'),
    ],

    'navbar' => [
        'brand_long' => 'PMB STAISPA',
        'brand' => 'PMB',
        'brand_ext' => 'STAISPA'
    ],

    'brosur' => 'http://pmb.staispa.ac.id/Brosur-PMB-STAISPA-2022-2023.pdf',

    'display_error_validations' => true,

    'footer' => [
    	'left'  => 'PMB '.env('APP_NAME'),
        'right' => 'Copyright &copy; 2022'
    ],

    // 'maximum-grades' => 3,
    // 'maximum-dob-year' => '2007-01-01 00:00:00',
    'code' => 'stai',

    'sex-transform' => [
        0 => 'Putra',
        1 => 'Putri'
    ],
    'closed' => [],
    'maximum-grades' => 5,
    'maximum-test-per-day' => 1000,
    'maximum-dob-year' => '2001-01-01 00:00:00',

    'questions' => [
        'Teman setia bagi seseorang adalah akalnya, dan musuh yang nyata adalah kebodohannya.',
		'Barang siapa sedikit kejujurannya, maka sedikit pula temannya.',
		'Kebersihan itu bagian dari keimanan, dan kedisiplinan itu bagian dari keamanan.',
		'Sopo ngaji mesti aji.',
		'Berbuat itu menyebabkan yang sulit menjadi mudah.',
		'Siapa yang bersungguh-sungguh dia akan mendapatkan apa yang dicita-citakannya.',
    ],

    'questions-arab' => [
         'Surah al-Fatihah',
        'Surah an-Nashr',
        'Surah an-Nas',
        'Surah al-Kautsar',
        'Surah al-Falaq',
        'Surah al-Ikhlas'
    ],

    'admin' => [
        'navbar' => [
            'brand' => 'PMB',
            'brand_ext' => 'STAISPA'
        ],
        'menus' => [
            [
                'items' => [
                    [
                        'route' => 'admission.admin.dashboard',
                        'permissions' => 1,
                        'icon' => 'speedometer',
                        'label' => 'Dasbor'
                    ],
                    [
                        'route' => 'admission.admin.database.manage.registrants.create',
                        'permissions' => 'manage-registrants',
                        'icon' => 'plus-circle-outline',
                        'label' => 'Daftarkan maba'
                    ],
                ]
            ],
            [
                'title' => 'Pendaftaran',
                'items' => [
                    [
                        'route' => 'admission.admin.registration.saman.index',
                        'permissions' => 'verify',
                        'icon' => 'check-circle',
                        'label' => 'Pilih SAMAN'
                    ],
                    [
                        'route' => 'admission.admin.registration.verification.index',
                        'permissions' => 'verify',
                        'icon' => 'check-circle',
                        'label' => 'Verifikasi'
                    ],
                    [
                        'route' => 'admission.admin.registration.test.index',
                        'permissions' => 'test',
                        'icon' => 'calculator',
                        'label' => 'Tahap tes'
                    ],
                    [
                        'route' => 'admission.admin.registration.validation.index',
                        'permissions' => 'validate',
                        'icon' => 'account-card-details',
                        'label' => 'Validasi data'
                    ],
                    // [
                    //     'route' => 'admission.admin.registration.agreement.index',
                    //     'permissions' => 'give-agreement',
                    //     'icon' => 'file-document-box-check-outline',
                    //     'label' => 'Perjanjian'
                    // ],
                    [
                        'route' => 'admission.admin.registration.payment.index',
                        'permissions' => 'accept-payment',
                        'icon' => 'wallet',
                        'label' => 'Pembayaran'
                    ],
                    [
                        'route' => 'admission.admin.registration.cbt.index',
                        'permissions' => 1,
                        'icon' => 'calculator',
                        'label' => 'Tes CBT'
                    ],
                ]
            ],
            [
                'title' => 'LAINNYA',
                'items' => [
                    [
                        'route' => 'admission.admin.spendings.index',
                        'permissions' => 'manage-admissions',
                        'icon' => 'account-cash',
                        'label' => 'Pengeluaran'
                    ],
                    [
                        'icon' => 'file-document-box-multiple',
                        'label' => 'Laporan',
                        'dropdown' => [
                            [
                                'route' => 'admission.admin.report.registrants.index',
                                'permissions' => 1,
                                'icon' => 'file-document-box-multiple',
                                'label' => 'Pendaftaran'
                            ],
                            [
                                'route' => 'admission.admin.report.payments.index',
                                'permissions' => 'accept-payment',
                                'icon' => 'file-document-box-multiple',
                                'label' => 'Pembayaran'
                            ]
                        ]
                    ],
                ]
            ],
            [
                'title' => 'PANGKALAN DATA',
                'items' => [
                    [
                        'icon' => 'layers',
                        'label' => 'Kelola',
                        'dropdown' => [
                            [
                                'route' => 'admission.admin.database.manage.registrants.index',
                                'permissions' => 'manage-registrants',
                                'icon' => 'layers',
                                'label' => 'Calon maba'
                            ],
                            [
                                'route' => 'admission.admin.cbt.index',
                                'permissions' => 1,
                                'icon' => 'layers',
                                'label' => 'Mapel CBT'
                            ],
                            [
                                'route' => 'admission.admin.tanggal_kedatangan.index',
                                'permissions' => 1,
                                'icon' => 'layers',
                                'label' => 'Tanggal Kedatangan'
                            ],
                            [
                                'route' => 'admission.admin.brochure.index',
                                'permissions' => 1,
                                'icon' => 'layers',
                                'label' => 'Brochure'
                            ],
                        ]
                    ],
                ]
            ]
        ]
    ]
];
