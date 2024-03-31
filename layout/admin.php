<?php defined( 'ABSPATH' ) || exit; ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> - Simpl</title>
        <!-- Zepto -->
        <script src="https://zeptojs.com/zepto.min.js" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <!-- Ionic -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <!-- Custom -->
        <link href="<?= ROOT ?>src/css/main.css" rel="stylesheet">
        <script src="<?= ROOT ?>src/js/main.js"></script>
    </head>
    <body>
        
        
        <div class="min-vh-100 bg-body-tertiary">

            <div class="p-3 px-4 border-bottom d-flex flex-row justify-content-between align-items-center bg-body">
                <a href="<?= ROOT ?>admin" id="logo">
                    <!--<img src="<?= ROOT ?>src/images/Simpl.CMS_Logo.png" width="80px">-->
                    <svg width="80" viewBox="0 0 1073 197" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M568.696 156.06C563.582 156.06 559.203 154.26 555.557 150.662C551.958 147.063 550.183 142.707 550.23 137.594C550.183 132.575 551.958 128.29 555.557 124.739C559.203 121.14 563.582 119.341 568.696 119.341C573.526 119.341 577.787 121.14 581.48 124.739C585.221 128.29 587.115 132.575 587.162 137.594C587.115 141.003 586.215 144.104 584.463 146.898C582.759 149.691 580.509 151.917 577.716 153.574C574.97 155.231 571.963 156.06 568.696 156.06ZM742.134 61.2443H706.622C706.149 57.5985 705.178 54.3078 703.71 51.3722C702.242 48.4366 700.301 45.9271 697.886 43.8438C695.472 41.7604 692.607 40.1742 689.293 39.0852C686.026 37.9489 682.403 37.3807 678.426 37.3807C671.371 37.3807 665.287 39.1089 660.173 42.5653C655.107 46.0218 651.201 51.017 648.455 57.5511C645.756 64.0852 644.406 71.9924 644.406 81.2727C644.406 90.9318 645.779 99.0284 648.526 105.562C651.319 112.049 655.225 116.95 660.244 120.264C665.311 123.531 671.3 125.165 678.213 125.165C682.096 125.165 685.623 124.668 688.795 123.673C692.015 122.679 694.832 121.235 697.247 119.341C699.709 117.4 701.722 115.056 703.284 112.31C704.894 109.516 706.007 106.367 706.622 102.864L742.134 103.077C741.518 109.516 739.648 115.861 736.523 122.111C733.445 128.361 729.207 134.066 723.81 139.227C718.412 144.341 711.83 148.413 704.065 151.443C696.348 154.473 687.493 155.989 677.503 155.989C664.34 155.989 652.55 153.1 642.134 147.324C631.764 141.5 623.573 133.025 617.56 121.898C611.546 110.771 608.54 97.2292 608.54 81.2727C608.54 65.2689 611.594 51.7036 617.702 40.5767C623.81 29.4498 632.072 20.9981 642.489 15.2216C652.905 9.44507 664.577 6.55681 677.503 6.55681C686.31 6.55681 694.454 7.78788 701.935 10.25C709.416 12.6648 715.997 16.2159 721.679 20.9034C727.361 25.5436 731.977 31.2491 735.528 38.0199C739.08 44.7907 741.281 52.5322 742.134 61.2443ZM762.251 8.54545H805.788L842.719 98.6023H844.424L881.356 8.54545H924.893V154H890.66V64.6534H889.452L854.509 153.077H832.634L797.691 64.1562H796.484V154H762.251V8.54545ZM1025.44 52.1534C1024.97 46.9451 1022.86 42.8968 1019.12 40.0085C1015.43 37.0729 1010.15 35.6051 1003.28 35.6051C998.739 35.6051 994.951 36.197 991.92 37.3807C988.89 38.5644 986.617 40.1979 985.102 42.2812C983.587 44.3172 982.806 46.661 982.759 49.3125C982.664 51.4905 983.09 53.4081 984.037 55.0653C985.031 56.7225 986.452 58.1903 988.298 59.4688C990.192 60.6998 992.465 61.7888 995.116 62.7358C997.768 63.6828 1000.75 64.5114 1004.07 65.2216L1016.57 68.0625C1023.76 69.625 1030.11 71.7083 1035.6 74.3125C1041.14 76.9167 1045.78 80.018 1049.52 83.6165C1053.31 87.215 1056.17 91.358 1058.11 96.0455C1060.05 100.733 1061.05 105.989 1061.1 111.812C1061.05 120.998 1058.73 128.882 1054.14 135.463C1049.54 142.045 1042.94 147.087 1034.32 150.591C1025.75 154.095 1015.41 155.847 1003.28 155.847C991.116 155.847 980.509 154.024 971.466 150.378C962.422 146.732 955.391 141.192 950.372 133.759C945.353 126.325 942.773 116.926 942.631 105.562H976.295C976.58 110.25 977.834 114.156 980.06 117.281C982.285 120.406 985.339 122.774 989.222 124.384C993.152 125.993 997.697 126.798 1002.86 126.798C1007.59 126.798 1011.62 126.159 1014.93 124.881C1018.29 123.602 1020.87 121.827 1022.67 119.554C1024.47 117.281 1025.4 114.677 1025.44 111.741C1025.4 108.995 1024.54 106.652 1022.89 104.71C1021.23 102.722 1018.67 101.017 1015.22 99.5966C1011.81 98.1288 1007.45 96.7794 1002.15 95.5483L986.949 91.9972C974.354 89.1089 964.435 84.4451 957.19 78.0057C949.946 71.5189 946.348 62.7595 946.395 51.7273C946.348 42.7311 948.762 34.8475 953.639 28.0767C958.516 21.3059 965.263 16.0265 973.881 12.2386C982.498 8.45075 992.323 6.55681 1003.36 6.55681C1014.62 6.55681 1024.4 8.47443 1032.69 12.3097C1041.02 16.0975 1047.48 21.4242 1052.08 28.2898C1056.67 35.1553 1059.01 43.1098 1059.11 52.1534H1025.44Z" fill="black"/>
                        <path d="M84.0366 52.3779C83.4684 46.6487 81.0299 42.198 76.7212 39.0256C72.4125 35.8533 66.565 34.2671 59.1786 34.2671C54.1597 34.2671 49.922 34.9773 46.4655 36.3978C43.0091 37.7709 40.3576 39.6885 38.511 42.1506C36.7118 44.6127 35.8121 47.4063 35.8121 50.5313C35.7174 53.1355 36.2619 55.4082 37.4457 57.3495C38.6767 59.2908 40.3576 60.9716 42.4883 62.3921C44.6189 63.7652 47.0811 64.9726 49.8746 66.0143C52.6682 67.0086 55.6511 67.8608 58.8235 68.5711L71.8917 71.6961C78.2364 73.1165 84.0602 75.0105 89.3633 77.3779C94.6663 79.7453 99.2591 82.6572 103.142 86.1137C107.024 89.5701 110.031 93.6421 112.162 98.3296C114.34 103.017 115.452 108.391 115.5 114.452C115.452 123.353 113.18 131.071 108.681 137.605C104.231 144.092 97.7913 149.135 89.3633 152.733C80.9826 156.284 70.8737 158.06 59.0366 158.06C47.2941 158.06 37.0669 156.26 28.3547 152.662C19.69 149.064 12.9191 143.737 8.04224 136.682C3.2127 129.58 0.679553 120.796 0.44281 110.332H30.2013C30.5328 115.209 31.9296 119.281 34.3917 122.548C36.9011 125.768 40.2392 128.206 44.4059 129.864C48.6199 131.474 53.3784 132.278 58.6814 132.278C63.8898 132.278 68.4116 131.521 72.2468 130.006C76.1294 128.491 79.136 126.384 81.2667 123.685C83.3974 120.986 84.4627 117.885 84.4627 114.381C84.4627 111.114 83.4921 108.367 81.5508 106.142C79.6568 103.917 76.8633 102.023 73.1701 100.46C69.5242 98.8978 65.0498 97.4773 59.7468 96.1989L43.9087 92.2216C31.6455 89.2387 21.9627 84.5749 14.8604 78.2302C7.75815 71.8855 4.23069 63.3391 4.27804 52.591C4.23069 43.7841 6.57444 36.09 11.3093 29.5086C16.0915 22.9271 22.6493 17.7898 30.9826 14.0966C39.3159 10.4035 48.7856 8.55686 59.3917 8.55686C70.1871 8.55686 79.6095 10.4035 87.6587 14.0966C95.7553 17.7898 102.053 22.9271 106.551 29.5086C111.049 36.09 113.369 43.7131 113.511 52.3779H84.0366Z" fill="url(#paint0_linear_8_16)"/>
                        <path d="M135.617 156V46.9091H165.872V156H135.617ZM150.816 32.8466C146.318 32.8466 142.459 31.3552 139.239 28.3722C136.067 25.3419 134.48 21.7197 134.48 17.5057C134.48 13.3391 136.067 9.76425 139.239 6.7813C142.459 3.75099 146.318 2.23584 150.816 2.23584C155.314 2.23584 159.149 3.75099 162.321 6.7813C165.541 9.76425 167.151 13.3391 167.151 17.5057C167.151 21.7197 165.541 25.3419 162.321 28.3722C159.149 31.3552 155.314 32.8466 150.816 32.8466Z" fill="url(#paint1_linear_8_16)"/>
                        <path d="M190.109 156V46.9091H218.944V66.1563H220.223C222.495 59.7643 226.283 54.7216 231.586 51.0285C236.889 47.3353 243.234 45.4887 250.62 45.4887C258.101 45.4887 264.47 47.359 269.725 51.0995C274.981 54.7927 278.485 59.8116 280.237 66.1563H281.373C283.599 59.9063 287.623 54.911 293.447 51.1705C299.318 47.3826 306.255 45.4887 314.257 45.4887C324.437 45.4887 332.699 48.7321 339.044 55.2188C345.436 61.6582 348.632 70.7964 348.632 82.6336V156H318.447V88.5995C318.447 82.5389 316.837 77.9934 313.618 74.9631C310.398 71.9328 306.373 70.4177 301.544 70.4177C296.051 70.4177 291.766 72.1696 288.689 75.6733C285.611 79.1298 284.072 83.6989 284.072 89.3807V156H254.74V87.9603C254.74 82.6099 253.201 78.3485 250.123 75.1762C247.093 72.0038 243.092 70.4177 238.12 70.4177C234.759 70.4177 231.728 71.2699 229.029 72.9745C226.378 74.6317 224.271 76.9754 222.708 80.0057C221.146 82.9887 220.365 86.4925 220.365 90.5171V156H190.109Z" fill="url(#paint2_linear_8_16)"/>
                        <path d="M372.531 196.909V46.9091H402.36V65.233H403.71C405.036 62.2974 406.953 59.3144 409.463 56.2841C412.02 53.2065 415.334 50.6497 419.406 48.6137C423.525 46.5304 428.639 45.4887 434.747 45.4887C442.701 45.4887 450.04 47.572 456.764 51.7387C463.487 55.858 468.861 62.0843 472.886 70.4177C476.911 78.7036 478.923 89.0966 478.923 101.597C478.923 113.765 476.958 124.04 473.028 132.421C469.145 140.754 463.842 147.075 457.119 151.384C450.443 155.645 442.962 157.776 434.676 157.776C428.805 157.776 423.809 156.805 419.69 154.864C415.618 152.922 412.28 150.484 409.676 147.548C407.072 144.565 405.083 141.559 403.71 138.528H402.787V196.909H372.531ZM402.147 101.455C402.147 107.941 403.047 113.599 404.846 118.429C406.645 123.259 409.25 127.023 412.659 129.722C416.068 132.373 420.211 133.699 425.088 133.699C430.012 133.699 434.179 132.349 437.588 129.651C440.997 126.904 443.577 123.117 445.329 118.287C447.128 113.41 448.028 107.799 448.028 101.455C448.028 95.1572 447.152 89.6175 445.4 84.8353C443.648 80.0531 441.068 76.3126 437.659 73.6137C434.25 70.9148 430.059 69.5654 425.088 69.5654C420.163 69.5654 415.997 70.8675 412.588 73.4716C409.226 76.0758 406.645 79.769 404.846 84.5512C403.047 89.3334 402.147 94.9679 402.147 101.455Z" fill="url(#paint3_linear_8_16)"/>
                        <path d="M529.349 10.5455V156H499.093V10.5455H529.349Z" fill="url(#paint4_linear_8_16)"/>
                        <defs>
                            <linearGradient id="paint0_linear_8_16" x1="123.5" y1="-251.5" x2="468.5" y2="332.5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#69B53F"/>
                                <stop offset="1" stop-color="#205133"/>
                            </linearGradient>
                            <linearGradient id="paint1_linear_8_16" x1="123.5" y1="-251.5" x2="468.5" y2="332.5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#69B53F"/>
                                <stop offset="1" stop-color="#205133"/>
                            </linearGradient>
                            <linearGradient id="paint2_linear_8_16" x1="123.5" y1="-251.5" x2="468.5" y2="332.5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#69B53F"/>
                                <stop offset="1" stop-color="#205133"/>
                            </linearGradient>
                            <linearGradient id="paint3_linear_8_16" x1="123.5" y1="-251.5" x2="468.5" y2="332.5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#69B53F"/>
                                <stop offset="1" stop-color="#205133"/>
                            </linearGradient>
                            <linearGradient id="paint4_linear_8_16" x1="123.5" y1="-251.5" x2="468.5" y2="332.5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#69B53F"/>
                                <stop offset="1" stop-color="#205133"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </a>
                <div class="d-flex flex-row align-items-center">
                    <a href="" toggle="mode" class="text-secondary px-2" data-bs-toggle="tooltip" data-bs-title="Switch mode">
                        <ion-icon name="moon" size="small"></ion-icon>
                    </a>

                    <a href="<?= ROOT ?>admin/profile" class="text-secondary px-2" data-bs-toggle="tooltip" data-bs-title="Profile">
                        <ion-icon name="person-circle-outline" size="small"></ion-icon>
                    </a>
                    <a href="<?= ROOT ?>admin/login" class="text-secondary px-2" data-bs-toggle="tooltip" data-bs-title="Sign out">
                        <ion-icon name="log-out-outline" size="small"></ion-icon>
                    </a>
                </div>
            </div>

            <div class="d-flex flex-row">
                <div class="w-30 p-4 pe-5 me-5 admin-sidebar">

                    <div class="d-flex flex-column nav nav-pills" id="sidebarMenu">
                        <a href="<?= ROOT ?>admin" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="speedometer" size="small" class="pe-2"></ion-icon>
                            Dashboard
                        </a>
                        <a href="<?= ROOT ?>admin/pages" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="document-outline" size="small" class="pe-2"></ion-icon>
                            Pages
                        </a>
                        <a href="<?= ROOT ?>admin/media" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="image-outline" size="small" class="pe-2"></ion-icon>
                            Media
                        </a>
                        <a href="<?= ROOT ?>admin/users" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="people-outline" size="small" class="pe-2"></ion-icon>
                            Users
                        </a>
                        <a href="<?= ROOT ?>admin/seo" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="search-outline" size="small" class="pe-2"></ion-icon>
                            SEO
                        </a>
                        <a href="<?= ROOT ?>admin/settings" class="nav-link text-secondary d-flex align-items-center hover-blue">
                            <ion-icon name="cog-outline" size="small" class="pe-2"></ion-icon>
                            Settings
                        </a>
                    </div>
                    
                </div>
                <div class="h-100 flex-fill p-4">
                    <?= $content ?>
                </div>
            </div>

        </div>

        <div class="modal fade modal-sm" id="alertModal" tabindex="-1" aria-labelledby="Confirmation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header p-0">
                        <div class="p-2 border-start rounded-0 ms-auto">
                            <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body p-2"></div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <a href="#"  class="btn btn-danger btn-sm" id="alertConfirm">Confirm</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $( `#sidebarMenu [href="${document.location.href.split('?')[0]}"]` ).addClass( 'text-body' );
            $( `#sidebarMenu [href="${document.location.href.split('?')[0]}"]` ).css( 'font-weight', 700 );

            // Function to toggle theme
            function toggleTheme( change = false ) {
                let currentTheme = localStorage.getItem('theme') || 'light';
                let newTheme = change ? (currentTheme === 'dark' ? 'light' : 'dark') : currentTheme;

                $('html').attr('data-bs-theme', newTheme);
                $('[toggle="mode"]').find('[name="moon"], [name="sunny"]').attr('name', newTheme === 'dark' ? 'sunny' : 'moon');

                localStorage.setItem('theme', newTheme);
            }

            // Initial call to toggle theme based on localStorage
            toggleTheme();

            // Click event handler for toggling theme
            $('[toggle="mode"]').on('click', function(e) {
                e.preventDefault();
                toggleTheme( true );
            });

        </script>
    </body>
</html>