<?php


class employees
{
    public $return= [
        "employees" => [
            "status"=>[
                "title" => [
                    0 => 'Resigned',
                    1 => 'Working',
                    2 => 'Terminated',
                    3 => 'Suspended',
                    4 => 'Warning',
                ],
                "value" => [
                    'resigned' => '0',
                    'working' => '1',
                    'terminated' => '2',
                    'suspended' => '3',
                    'warning' => '4',
                ],
                "icon" => [
                    0 => '<div class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100; height:16px; width:28px;" xml:space="preserve">
                            <style type="text/css">.sf0{fill:#F64E60;}.si0{fill:#FFFFFF;}</style>
                            <g>
                                <path class="sf0" d="M0,64.83c0.07-5.74,1.64-10.21,4.85-14.07c0.49-0.59,0.44-0.95-0.02-1.51c-3.97-4.88-5.45-10.46-4.58-16.66
                                c1.31-9.38,9.26-17.01,18.67-18.04c1.99-0.22,3.96-0.18,5.91,0.15c0.7,0.12,0.91-0.09,1.14-0.7c3.23-8.8,12.83-14.8,22.18-13.66
                                c8.05,0.99,13.81,5.34,17.34,12.63c0.89,1.85,0.85,1.77,2.89,1.58c7.2-0.68,13.27,1.67,18.11,7.05c2.59,2.88,4.3,6.24,5.05,10.05
                                c1.21,6.17-0.08,11.79-3.81,16.84c-1.13,1.53-1.16,1.52-0.01,3.04c5.87,7.76,5.69,18.58-0.56,26.13
                                c-5.08,6.15-11.65,8.71-19.57,7.71c-0.98-0.12-1.42,0.1-1.83,1.07c-3.2,7.6-9.01,12.02-17.09,13.17c-9.08,1.29-18-3.7-22.08-11.94
                                c-0.38-0.77-0.3-1.94-1.11-2.25c-0.7-0.27-1.64,0.12-2.47,0.16c-10.47,0.57-19.05-5.41-22.19-15.5C0.24,68.14-0.04,66.14,0,64.83z"/>
                                <g>
                                    <rect x="23.61" y="45.32" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -21.8823 47.1716)" class="si0" width="44.78" height="9.37"/>
                                    <rect x="23.61" y="45.32" transform="matrix(0.7071 0.7071 -0.7071 0.7071 48.8284 -17.8823)" class="si0" width="44.78" height="9.37"/>
                                </g>
                            </g>
                        </svg>
                        <span class="Tool-Tip-Text Tool-Danger">Resigned</span>
                    </div>',
                    1 => '<div class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100;height:16px; width:28px;" xml:space="preserve">
                            <style type="text/css">.sf1{fill:#1BC4BC;}.si1{fill:#FFFFFF;}</style>
	                        <g>
	                            <path class="sf1" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                            C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                            c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                            c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                            c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99
	                            c-0.38-0.77-0.3-1.95-1.11-2.26c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                            <g>
	                                <rect x="23.36" y="53.26" transform="matrix(0.7071 0.7071 -0.7071 0.7071 51.1113 -7.476)" class="si1" width="22.45" height="9.4"/>
	                                <rect x="29.28" y="45.3" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -20.1947 51.2457)" class="si1" width="44.96" height="9.4"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Success">Working</span>
                    </div>',
                    2 => '<div class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100;height:16px; width:28px;" xml:space="preserve">
                            <style type="text/css">.sf0{fill:#F64E60;}.si0{fill:#FFFFFF;}</style>
                            <g>
                                <path class="sf0" d="M0,64.83c0.07-5.74,1.64-10.21,4.85-14.07c0.49-0.59,0.44-0.95-0.02-1.51c-3.97-4.88-5.45-10.46-4.58-16.66
                                c1.31-9.38,9.26-17.01,18.67-18.04c1.99-0.22,3.96-0.18,5.91,0.15c0.7,0.12,0.91-0.09,1.14-0.7c3.23-8.8,12.83-14.8,22.18-13.66
                                c8.05,0.99,13.81,5.34,17.34,12.63c0.89,1.85,0.85,1.77,2.89,1.58c7.2-0.68,13.27,1.67,18.11,7.05c2.59,2.88,4.3,6.24,5.05,10.05
                                c1.21,6.17-0.08,11.79-3.81,16.84c-1.13,1.53-1.16,1.52-0.01,3.04c5.87,7.76,5.69,18.58-0.56,26.13
                                c-5.08,6.15-11.65,8.71-19.57,7.71c-0.98-0.12-1.42,0.1-1.83,1.07c-3.2,7.6-9.01,12.02-17.09,13.17c-9.08,1.29-18-3.7-22.08-11.94
                                c-0.38-0.77-0.3-1.94-1.11-2.25c-0.7-0.27-1.64,0.12-2.47,0.16c-10.47,0.57-19.05-5.41-22.19-15.5C0.24,68.14-0.04,66.14,0,64.83z"/>
                                <g>
                                    <rect x="23.61" y="45.32" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -21.8823 47.1716)" class="si0" width="44.78" height="9.37"/>
                                    <rect x="23.61" y="45.32" transform="matrix(0.7071 0.7071 -0.7071 0.7071 48.8284 -17.8823)" class="si0" width="44.78" height="9.37"/>
                                </g>
                            </g>
                        </svg>
	                    <span class="Tool-Tip-Text Tool-Danger">Terminated</span>
                    </div>',
                    3 => '<div class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100; height:16px; width:28px;" xml:space="preserve">
                            <style type="text/css">.sf3{fill:#FFA800;}.si3{fill:#FFFFFF;}</style>
                            <path class="sf3" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                        C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                        c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                        c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                        c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99c-0.38-0.77-0.3-1.95-1.11-2.26
	                        c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                        <g>
	                            <path class="si3" d="M39.94,67.08c0-3.31,2.6-5.78,6.24-5.78s6.24,2.47,6.24,5.78c0,3.25-2.6,5.91-6.24,5.91 S39.94,70.33,39.94,67.08z M40.14,27.01h12.08l-2.01,29.69h-8.05L40.14,27.01z"/>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Warning">Suspended</span>
                    </div>',
                    4 => '<div class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100; height:16px; width:28px;" xml:space="preserve">
                            <style type="text/css">.sf3{fill:#FFA800;}.si3{fill:#FFFFFF;}</style>
                            <path class="sf3" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                        C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                        c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                        c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                        c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99c-0.38-0.77-0.3-1.95-1.11-2.26
	                        c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                        <g>
	                            <path class="si3" d="M39.94,67.08c0-3.31,2.6-5.78,6.24-5.78s6.24,2.47,6.24,5.78c0,3.25-2.6,5.91-6.24,5.91 S39.94,70.33,39.94,67.08z M40.14,27.01h12.08l-2.01,29.69h-8.05L40.14,27.01z"/>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Warning">Warning</span>
                    </div>',
                ],
                "profile_status" => [
                    0 => '<div class="Tool-Tip"><i class="symbol-badge bg-danger" style="cursor:pointer;left:-6px;top:0px;"></i><span class="Tool-Tip-Text Tool-Danger">Resigned</span></div>',
                    1 => '<div class="Tool-Tip"><i class="symbol-badge bg-success" style="cursor:pointer;left:-6px;top:0px;"></i><span class="Tool-Tip-Text Tool-Success">Working</span></div>',
                    2 => '<div class="Tool-Tip"><i class="symbol-badge bg-danger" style="cursor:pointer;left:-6px;top:0px;"></i><span class="Tool-Tip-Text Tool-Danger">Terminated</span></div>',
                    3 => '<div class="Tool-Tip"><i class="symbol-badge bg-warning" style="cursor:pointer;left:-6px;top:0px;"></i><span class="Tool-Tip-Text Tool-Warning">Suspended</span></div>',
                    4 => '<div class="Tool-Tip"><i class="symbol-badge bg-warning" style="cursor:pointer;left:-6px;top:0px;"></i><span class="Tool-Tip-Text Tool-Warning">Warning</span></div>',
                ],
                "class" => [
                    0 => 'bg-danger',
                    1 => 'bg-success',
                    2 => 'bg-danger',
                    3 => 'bg-warning',
                    4 => 'bg-warning',
                ],
            ],
        ],
    ];

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function getArray()
    {
        return $this->return;
    }

}
?>