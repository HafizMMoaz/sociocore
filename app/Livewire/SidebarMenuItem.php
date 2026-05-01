<?php

namespace App\Livewire;

use Livewire\Component;

class SidebarMenuItem extends Component
{

    public $name;
    public $link;
    public $icon;
    public $active = false;
    public $badge;

    public function mount()
    {
        $this->icon = $this->setIcon($this->icon);
    }

    public function setIcon($icon)
    {
        switch ($icon) {

        case 'dashboard':
            $this->icon = '<svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 -0.5 25 25" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001H9.35ZM10.1 16.7691L9.35055 16.7404C9.35018 16.75 9.35 16.7595 9.35 16.7691H10.1ZM12.5 14.5391L12.4736 15.2886C12.4912 15.2892 12.5088 15.2892 12.5264 15.2886L12.5 14.5391ZM14.9 16.7691H15.65C15.65 16.7595 15.6498 16.75 15.6495 16.7404L14.9 16.7691ZM14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001H14.15ZM10.1 18.2501C9.68579 18.2501 9.35 18.5859 9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501V18.2501ZM14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001C15.65 18.5859 15.3142 18.2501 14.9 18.2501V19.7501ZM10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001C10.85 18.5859 10.5142 18.2501 10.1 18.2501V19.7501ZM9.5 19.0001V18.2501C9.4912 18.2501 9.4824 18.2502 9.4736 18.2505L9.5 19.0001ZM5.9 15.6541H5.15C5.15 15.6635 5.15018 15.673 5.15054 15.6825L5.9 15.6541ZM6.65 8.94807C6.65 8.53386 6.31421 8.19807 5.9 8.19807C5.48579 8.19807 5.15 8.53386 5.15 8.94807H6.65ZM3.0788 9.95652C2.73607 10.1891 2.64682 10.6555 2.87944 10.9983C3.11207 11.341 3.57848 11.4302 3.9212 11.1976L3.0788 9.95652ZM6.3212 9.56863C6.66393 9.336 6.75318 8.86959 6.52056 8.52687C6.28793 8.18415 5.82152 8.09489 5.4788 8.32752L6.3212 9.56863ZM5.47883 8.3275C5.13609 8.5601 5.04682 9.02651 5.27942 9.36924C5.51203 9.71198 5.97844 9.80125 6.32117 9.56865L5.47883 8.3275ZM11.116 5.40807L10.7091 4.77804C10.7043 4.78114 10.6995 4.78429 10.6948 4.7875L11.116 5.40807ZM13.884 5.40807L14.3052 4.7875C14.3005 4.78429 14.2957 4.78114 14.2909 4.77804L13.884 5.40807ZM18.6788 9.56865C19.0216 9.80125 19.488 9.71198 19.7206 9.36924C19.9532 9.02651 19.8639 8.5601 19.5212 8.3275L18.6788 9.56865ZM14.9 18.2501C14.4858 18.2501 14.15 18.5859 14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501V18.2501ZM15.5 19.0001L15.5264 18.2505C15.5176 18.2502 15.5088 18.2501 15.5 18.2501V19.0001ZM19.1 15.6541L19.8495 15.6825C19.8498 15.673 19.85 15.6635 19.85 15.6541L19.1 15.6541ZM19.85 8.94807C19.85 8.53386 19.5142 8.19807 19.1 8.19807C18.6858 8.19807 18.35 8.53386 18.35 8.94807H19.85ZM21.079 11.1967C21.4218 11.4293 21.8882 11.3399 22.1207 10.9971C22.3532 10.6543 22.2638 10.1879 21.921 9.9554L21.079 11.1967ZM19.521 8.3274C19.1782 8.09487 18.7119 8.18426 18.4793 8.52705C18.2468 8.86984 18.3362 9.33622 18.679 9.56875L19.521 8.3274ZM10.85 19.0001V16.7691H9.35V19.0001H10.85ZM10.8495 16.7977C10.8825 15.9331 11.6089 15.2581 12.4736 15.2886L12.5264 13.7895C10.8355 13.73 9.41513 15.0497 9.35055 16.7404L10.8495 16.7977ZM12.5264 15.2886C13.3911 15.2581 14.1175 15.9331 14.1505 16.7977L15.6495 16.7404C15.5849 15.0497 14.1645 13.73 12.4736 13.7895L12.5264 15.2886ZM14.15 16.7691V19.0001H15.65V16.7691H14.15ZM10.1 19.7501H14.9V18.2501H10.1V19.7501ZM10.1 18.2501H9.5V19.7501H10.1V18.2501ZM9.4736 18.2505C7.96966 18.3035 6.70648 17.1294 6.64946 15.6257L5.15054 15.6825C5.23888 18.0125 7.19612 19.8317 9.5264 19.7496L9.4736 18.2505ZM6.65 15.6541V8.94807H5.15V15.6541H6.65ZM3.9212 11.1976L6.3212 9.56863L5.4788 8.32752L3.0788 9.95652L3.9212 11.1976ZM6.32117 9.56865L11.5372 6.02865L10.6948 4.7875L5.47883 8.3275L6.32117 9.56865ZM11.5229 6.0381C12.1177 5.65397 12.8823 5.65397 13.4771 6.0381L14.2909 4.77804C13.2008 4.07399 11.7992 4.07399 10.7091 4.77804L11.5229 6.0381ZM13.4628 6.02865L18.6788 9.56865L19.5212 8.3275L14.3052 4.7875L13.4628 6.02865ZM14.9 19.7501H15.5V18.2501H14.9V19.7501ZM15.4736 19.7496C17.8039 19.8317 19.7611 18.0125 19.8495 15.6825L18.3505 15.6257C18.2935 17.1294 17.0303 18.3035 15.5264 18.2505L15.4736 19.7496ZM19.85 15.6541V8.94807H18.35V15.6541H19.85ZM21.921 9.9554L19.521 8.3274L18.679 9.56875L21.079 11.1967L21.921 9.9554Z" fill="currentColor"></path> </g></svg>';
                break;

        case 'society':
            $this->icon = '<svg width="16" height="16" fill="currentColor" class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-shop"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"></path> </g></svg>';
                break;

        case 'users':
                $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                    </svg>';
                    break;

        case 'rents':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="1.5" d="M3 21h18M4 18h16M6 10v8m4-8v8m4-8v8m4-8v8M4 9.5v-.955a1 1 0 0 1 .458-.84l7-4.52a1 1 0 0 1 1.084 0l7 4.52a1 1 0 0 1 .458.84V9.5a.5.5 0 0 1-.5.5h-15a.5.5 0 0 1-.5-.5Z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
            break;

        case 'tickets':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/>
            </svg>';
            break;

        case 'owners':
            $this->icon = '<svg fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M256.001,238.426c65.738,0,119.219-53.48,119.219-119.219C375.221,53.475,321.739,0,256.001,0 S136.782,53.475,136.782,119.207C136.782,184.946,190.263,238.426,256.001,238.426z M256.001,38.705 c44.397,0,80.516,36.114,80.516,80.503c0,44.397-36.119,80.516-80.516,80.516s-80.516-36.119-80.516-80.516 C175.485,74.819,211.606,38.705,256.001,38.705z"></path> <path d="M256.001,253.692c-97.97,0-177.583,79.741-177.583,177.583v61.376c0,10.687,8.664,19.352,19.352,19.352h316.462 c10.687,0,19.352-8.664,19.352-19.352v-61.377C433.584,333.215,353.747,253.692,256.001,253.692z M185.045,473.298h-67.923 c0-38.412-8.95-115.482,67.923-161.362V473.298z M288.254,473.299h-64.506v-24.156h64.506V473.299z M288.254,410.44h-64.506 V296.184c4.229-1.01,8.533-1.823,12.901-2.434v13.23c0,10.687,8.664,19.352,19.352,19.352s19.352-8.664,19.352-19.352v-13.23 c4.368,0.612,8.672,1.424,12.901,2.434V410.44z M394.881,473.298h-67.923V311.935 C403.476,357.604,394.881,434.069,394.881,473.298z"></path> </g> </g> </g> </g></svg>';
                break;

        case 'tower_management':
            $this->icon = '<svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 25 25" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 19L9 16M9 16L9 12M15 12V19M15 19L15 16M9 16H15M12 19V12M4 21H20M4 8L8 4L16 4L20 8V21H4V8Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
            break;

        case 'notice_board':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16"><path d="M2 0h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zM4.5 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM5 5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 5 5zm-1 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6A.5.5 0 0 1 4 7.5zM4 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 4 10zM2.5 1.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5z"/></svg>';
                break;

        case 'utility_bills_management':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M8 2h8a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke-width="1.5"/>
                <path d="M12 8h4" stroke-width="1.5"/>
                <path d="M12 12h4" stroke-width="1.5"/>
                <path d="M8 16h8" stroke-width="1.5"/>
                <path d="M8 20h8" stroke-width="1.5"/>
            </svg>';
            break;


        case 'maintenance':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 30 30">
                <path d="M6,9.3L3.9,5.8l1.4-1.4l3.5,2.1v1.4l3.6,3.6c0,0.1,0,0.2,0,0.3L11.1,13L7.4,9.3H6z M21,17.8c-0.3,0-0.5,0-0.8,0  c0,0,0,0,0,0c-0.7,0-1.3-0.1-1.9-0.2l-2.1,2.4l4.7,5.3c1.1,1.2,3,1.3,4.1,0.1c1.2-1.2,1.1-3-0.1-4.1L21,17.8z M24.4,14  c1.6-1.6,2.1-4,1.5-6.1c-0.1-0.4-0.6-0.5-0.8-0.2l-3.5,3.5l-2.8-2.8l3.5-3.5c0.3-0.3,0.2-0.7-0.2-0.8C20,3.4,17.6,3.9,16,5.6  c-1.8,1.8-2.2,4.6-1.2,6.8l-10,8.9c-1.2,1.1-1.3,3-0.1,4.1l0,0c1.2,1.2,3,1.1,4.1-0.1l8.9-10C19.9,16.3,22.6,15.9,24.4,14z"/>
            </svg>';
            break;

        case 'bookAmenity':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                </svg>';
            break;


        case 'settings':
                $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white bi bi-gear" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                    </svg>';
                break;

        case 'tenants':
                $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
                    <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708z"/>
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514"/>
                    </svg>';

        case 'amenities':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="1.5"/>
                <path d="M7 9h4v4H7V9z" stroke-width="1.5"/>
                <path d="M13 9h4v4h-4V9z" stroke-width="1.5"/>
                <path d="M7 15h4v4H7v-4z" stroke-width="1.5"/>
                <path d="M13 15h4v4h-4v-4z" stroke-width="1.5"/>
            </svg>';
            break;


        case 'parking_management':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="2" y="2" width="20" height="20" rx="4" ry="4" stroke-width="1.5" />
                <path d="M9 8h4a2 2 0 0 1 0 4H9V8Z" stroke-width="1.5" />
                <path d="M9 12h4a2 2 0 0 0 0-4H9v8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>';
            break;

        case 'apartments':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16">
                <path d="M8 .5L15 7v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7l7-6.5z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 9v6h10V9H3zm5 6V9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
            break;

        case 'floor':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16">
                <path d="M1 1h14v14H1V1zm1 1v2h2V2H2zm0 3v2h2V5H2zm0 3v2h2V8H2zm0 3v2h2v-2H2zm3-9v2h2V2H5zm0 3v2h2V5H5zm0 3v2h2V8H5zm0 3v2h2v-2H5zm3-9v2h2V2H8zm0 3v2h2V5H8zm0 3v2h2V8H8zm0 3v2h2v-2H8zm3-9v2h2V2h-2zm0 3v2h2V5h-2zm0 3v2h2V8h-2zm0 3v2h2v-2h-2z"/>
            </svg>';
            break;

        case 'common_area_bills':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white bi bi-cash" viewBox="0 0 16 16">
                <path d="M12 0a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1h8zM4 1v14h8V1H4z"/>
                <path d="M7 3a1 1 0 0 1 1 1v1H5V4a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v1h-3V4a1 1 0 0 1 1-1z"/>
                <path d="M8 8.5a.5.5 0 0 1 .5.5V10H7V9a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 .5.5V10H9V9a.5.5 0 0 1 .5-.5z"/>
            </svg>';
            break;

        case 'service_management':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white bi bi-briefcase" viewBox="0 0 16 16">
                <path d="M6.5 0a.5.5 0 0 0-.5.5V2h-2A1.5 1.5 0 0 0 2.5 3.5v9A1.5 1.5 0 0 0 4 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 12 2h-2V.5a.5.5 0 0 0-.5-.5h-3zM11 2v1H5V2h6zM3.5 4h9a.5.5 0 0 1 .5.5v3.587a1.99 1.99 0 0 0-1-.787V5h-8v2.3a1.99 1.99 0 0 0-1 .787V4.5a.5.5 0 0 1 .5-.5zm0 4.213V13.5a.5.5 0 0 1-.5.5h-1v-2a.5.5 0 0 1 .5-.5h2v1.213a1.99 1.99 0 0 0 1-.787V8.213a1.99 1.99 0 0 0-1-.787zM12 14h-8v-1.213a1.99 1.99 0 0 0 1-.787V9h6v2.213a1.99 1.99 0 0 0 1 .787V14zM3.5 11H2v2h1.5v-2zm11-2h-1.5V9H15v1.213a1.99 1.99 0 0 0-1 .787V13.5h1v-2a.5.5 0 0 1 .5-.5H15v-1.213a1.99 1.99 0 0 0-1-.787V9z"/>
            </svg>';
            break;

        case 'visitor_management':
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 3C9.79 3 8 4.79 8 6C8 7.21 9.79 9 12 9C14.21 9 16 7.21 16 6C16 4.79 14.21 3 12 3ZM4 11C2.89 11 2 11.89 2 13C2 14.1 2.89 15 4 15C5.1 15 6 14.1 6 13C6 11.89 5.1 11 4 11ZM20 11C18.89 11 18 11.89 18 13C18 14.1 18.89 15 20 15C21.1 15 22 14.1 22 13C22 11.89 21.1 11 20 11ZM4 17C2.89 17 2 17.89 2 19C2 20.1 2.89 21 4 21C5.1 21 6 20.1 6 19C6 17.89 5.1 17 4 17ZM12 17C10.89 17 10 17.89 10 19C10 20.1 10.89 21 12 21C13.1 21 14 20.1 14 19C14 17.89 13.1 17 12 17ZM20 17C18.89 17 18 17.89 18 19C18 20.1 18.89 21 20 21C21.1 21 22 20.1 22 19C22 17.89 21.1 17 20 17Z"/>
            </svg>';
            break;

        case 'packages' :
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 16 16">
                <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
            </svg>';
            break;

        case 'billing' :
            $this->icon = '<svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" style="opacity:.8" width="24" height="24" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48H0z" fill="none"/><path d="m6 44 9-4 9 4 9-4 9 4V4H6zm4-36h28v29.845l-3.375-1.5L33 35.623l-1.625.722L24 39.623l-7.375-3.278L15 35.623l-1.625.722-3.375 1.5z"/><path d="M14 12h20v4H14zm0 8h20v4H14zm0 8h12v4H14z"/></svg>';
            break;
            
        case 'offline-plan-request':
            $this->icon ='<svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m8.38 12 2.41 2.42 4.83-4.84" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.75 2.45c.69-.59 1.82-.59 2.52 0l1.58 1.36c.3.26.86.47 1.26.47h1.7c1.06 0 1.93.87 1.93 1.93v1.7c0 .39.21.96.47 1.26l1.36 1.58c.59.69.59 1.82 0 2.52l-1.36 1.58c-.26.3-.47.86-.47 1.26v1.7c0 1.06-.87 1.93-1.93 1.93h-1.7c-.39 0-.96.21-1.26.47l-1.58 1.36c-.69.59-1.82.59-2.52 0l-1.58-1.36c-.3-.26-.86-.47-1.26-.47H6.18c-1.06 0-1.93-.87-1.93-1.93V16.1c0-.39-.21-.95-.46-1.25l-1.35-1.59c-.58-.69-.58-1.81 0-2.5l1.35-1.59c.25-.3.46-.86.46-1.25V6.2c0-1.06.87-1.93 1.93-1.93h1.73c.39 0 .96-.21 1.26-.47z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            break;

        case 'landing' :
            $this->icon = '<svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" style="opacity:.9" width="24" height="24" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"/><g stroke-linecap="round" stroke-linejoin="round"/><g data-name="Layer 2"><path fill="none" data-name="invisible box" d="M0 0h48v48H0z"/><g data-name="icons Q2"><path d="M7 34h12a2 2 0 0 0 0-4H9V10h30v20H29a2 2 0 0 0 0 4h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2m37 4H4a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4"/><path d="M31.9 21.3A5.7 5.7 0 0 0 32 20a5.7 5.7 0 0 0-.1-1.3l-2.2-.5a4.2 4.2 0 0 0-.4-1l1.2-1.9a7.7 7.7 0 0 0-1.8-1.8l-1.9 1.2-1-.4-.5-2.2h-2.6l-.5 2.2-1 .4-1.9-1.2a7.7 7.7 0 0 0-1.8 1.8l1.2 1.9a4.2 4.2 0 0 0-.4 1l-2.2.5A5.7 5.7 0 0 0 16 20a5.7 5.7 0 0 0 .1 1.3l2.2.5a4.2 4.2 0 0 0 .4 1l-1.2 1.9a7.7 7.7 0 0 0 1.8 1.8l1.9-1.2 1 .4.5 2.2h2.6l.5-2.2 1-.4 1.9 1.2a7.7 7.7 0 0 0 1.8-1.8l-1.2-1.9a4.2 4.2 0 0 0 .4-1ZM24 22a2 2 0 1 1 2-2 2 2 0 0 1-2 2"/></g></g></svg>';
            break;

        default:
            $this->icon = '<svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" viewBox="0 -0.5 25 25" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.41728 18.9999C9.41728 19.4142 9.75307 19.7499 10.1673 19.7499C10.5815 19.7499 10.9173 19.4142 10.9173 18.9999H9.41728ZM10.1673 16.6669H9.41728H10.1673ZM14.0853 18.9999C14.0853 19.4142 14.4211 19.7499 14.8353 19.7499C15.2495 19.7499 15.5853 19.4142 15.5853 18.9999H14.0853ZM10.1673 19.7499C10.5815 19.7499 10.9173 19.4142 10.9173 18.9999C10.9173 18.5857 10.5815 18.2499 10.1673 18.2499V19.7499ZM7.83328 18.9999L7.82564 19.7499H7.83328V18.9999ZM5.80128 17.2529L5.0518 17.2807C5.05294 17.3116 5.056 17.3424 5.06095 17.373L5.80128 17.2529ZM5.53228 9.99395L6.28177 9.96617C6.2805 9.93188 6.27687 9.8977 6.27092 9.8639L5.53228 9.99395ZM6.64428 7.74195L6.3033 7.07392L6.29848 7.07642L6.64428 7.74195ZM11.5793 5.22295L11.9203 5.89096L11.9218 5.89017L11.5793 5.22295ZM13.4243 5.22295L13.0818 5.89017L13.0833 5.89096L13.4243 5.22295ZM18.3593 7.74195L18.7051 7.07641L18.7003 7.07394L18.3593 7.74195ZM19.4713 9.99395L18.7326 9.8639C18.7267 9.89767 18.7231 9.93181 18.7218 9.96607L19.4713 9.99395ZM19.2013 17.2529L19.9416 17.373C19.9466 17.3425 19.9496 17.3117 19.9508 17.2808L19.2013 17.2529ZM17.1693 18.9999V19.75L17.1769 19.7499L17.1693 18.9999ZM14.8353 18.2499C14.4211 18.2499 14.0853 18.5857 14.0853 18.9999C14.0853 19.4142 14.4211 19.7499 14.8353 19.7499V18.2499ZM10.1673 18.2499C9.75307 18.2499 9.41728 18.5857 9.41728 18.9999C9.41728 19.4142 9.75307 19.7499 10.1673 19.7499V18.2499ZM14.8353 19.7499C15.2495 19.7499 15.5853 19.4142 15.5853 18.9999C15.5853 18.5857 15.2495 18.2499 14.8353 18.2499V19.7499ZM10.9173 18.9999V16.6669H9.41728V18.9999H10.9173ZM10.9173 16.6669C10.9173 15.7921 11.6265 15.0829 12.5013 15.0829V13.5829C10.798 13.5829 9.41728 14.9637 9.41728 16.6669H10.9173ZM12.5013 15.0829C13.3761 15.0829 14.0853 15.7921 14.0853 16.6669H15.5853C15.5853 14.9637 14.2045 13.5829 12.5013 13.5829V15.0829ZM14.0853 16.6669V18.9999H15.5853V16.6669H14.0853ZM10.1673 18.2499H7.83328V19.7499H10.1673V18.2499ZM7.84092 18.25C7.1937 18.2434 6.64521 17.7718 6.54162 17.1329L5.06095 17.373C5.28137 18.7325 6.44847 19.7359 7.82564 19.7499L7.84092 18.25ZM6.55077 17.2252L6.28177 9.96617L4.7828 10.0217L5.0518 17.2807L6.55077 17.2252ZM6.27092 9.8639C6.16697 9.27348 6.45811 8.68388 6.99008 8.40747L6.29848 7.07642C5.18533 7.65481 4.57613 8.88855 4.79364 10.124L6.27092 9.8639ZM6.98526 8.40996L11.9203 5.89096L11.2383 4.55494L6.30331 7.07394L6.98526 8.40996ZM11.9218 5.89017C12.2859 5.70328 12.7177 5.70328 13.0818 5.89017L13.7668 4.55573C12.9727 4.14809 12.0309 4.14809 11.2368 4.55573L11.9218 5.89017ZM13.0833 5.89096L18.0183 8.40996L18.7003 7.07394L13.7653 4.55494L13.0833 5.89096ZM18.0135 8.40747C18.5455 8.68388 18.8366 9.27348 18.7326 9.8639L20.2099 10.124C20.4274 8.88855 19.8182 7.65481 18.7051 7.07642L18.0135 8.40747ZM18.7218 9.96607L18.4518 17.2251L19.9508 17.2808L20.2208 10.0218L18.7218 9.96607ZM18.461 17.1329C18.3574 17.7718 17.8089 18.2434 17.1616 18.25L17.1769 19.7499C18.5541 19.7359 19.7212 18.7325 19.9416 17.373L18.461 17.1329ZM17.1693 18.2499H14.8353V19.7499H17.1693V18.2499ZM10.1673 19.7499H14.8353V18.2499H10.1673V19.7499Z" fill="currentColor"></path> </g></svg>';
                break;
        }

        return $this->icon;
    }

    public function render()
    {
        return view('livewire.sidebar-menu-item');
    }

}
