<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="dist/images/logo.png">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-theme-29 py-5 hidden">
        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'manage-gea-currency' || $page == 'manage-gea-product') {
                                                    echo 'menu--active';
                                                } ?>">
                <div class="menu__icon"> <i data-feather="package"></i> </div>
                <div class="menu__title">
                    GEA Manage
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'manage-gea-currency' || $page == 'manage-gea-product') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="manage-gea-currency" class="menu <?php if ($page == 'manage-gea-currency') {
                                                                    echo 'menu--active';
                                                                } ?>">
                        <div class="menu__icon"> <i data-feather="dollar-sign"></i> </div>
                        <div class="menu__title"> Manage GEA Currency </div>
                    </a>
                </li>
                <li>
                    <a href="manage-gea-product" class="menu <?php if ($page == 'manage-gea-product') {
                                                                    echo 'menu--active';
                                                                } ?>">
                        <div class="menu__icon"> <i data-feather="zap"></i> </div>
                        <div class="menu__title"> Manage GEA Product </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'manage-countries' || $page == 'add-country' || $page == 'manage-country-document') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title">
                    Countries
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'manage-countries') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="manage-countries" class="menu <?php if ($page == 'manage-countries') {
                                                                    echo 'menu--active';
                                                                } ?>">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Manage Country </div>
                    </a>
                </li>
                <li>
                    <a href="add-country" class="menu <?php if ($page == 'add-country') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="plus-circle"></i> </div>
                        <div class="menu__title"> Add New Country </div>
                    </a>
                </li>
                <li>
                    <a href="manage-country-document" class="menu <?php if ($page == 'manage-country-document') {
                                                                            echo 'menu--active';
                                                                        } ?>">
                        <div class="menu__icon"> <i data-feather="package"></i> </div>
                        <div class="menu__title"> Manage Country Doc. </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'manage-users') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="user"></i> </div>
                <div class="menu__title">
                    Users
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'manage-users') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="manage-users" class="menu <?php if ($page == 'manage-users') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="users"></i> </div>
                        <div class="menu__title"> Manage Users </div>
                    </a>
                </li>
                <li>
                    <a href="user-balance" class="menu <?php if ($page == 'user-balance') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="dollar-sign"></i> </div>
                        <div class="menu__title"> User Balance </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'manage-document' || $page == 'add-document') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="paperclip"></i> </div>
                <div class="menu__title">
                    Document
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'manage-document') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="manage-document" class="menu <?php if ($page == 'manage-document') {
                                                                    echo 'menu--active';
                                                                } ?>">
                        <div class="menu__icon"> <i data-feather="paperclip"></i> </div>
                        <div class="menu__title"> Manage Document </div>
                    </a>
                </li>
                <li>
                    <a href="add-document" class="menu <?php if ($page == 'add-document') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="file-plus"></i> </div>
                        <div class="menu__title"> Add New Document </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'kyc-request') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="grid"></i> </div>
                <div class="menu__title">
                    KYC
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'kyc-request') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="kyc-request" class="menu <?php if ($page == 'kyc-request') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="grid"></i> </div>
                        <div class="menu__title"> KYC Request </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'manage-level' || $page == 'add-level') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="trending-up"></i> </div>
                <div class="menu__title">
                    Level
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'manage-level') {
                            echo 'menu__sub-open';
                        } ?>">
                <li>
                    <a href="manage-level" class="menu <?php if ($page == 'manage-level') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="trending-up"></i> </div>
                        <div class="menu__title"> Manage Level </div>
                    </a>
                </li>
                <li>
                    <a href="add-level" class="menu <?php if ($page == 'add-level') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="plus-circle"></i> </div>
                        <div class="menu__title"> Add New Level </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu <?php if ($page == 'page-setup' || $page == 'add-new-page' || $page == 'manage-pages') {
                                                        echo 'menu--active';
                                                    } ?>">
                <div class="menu__icon"> <i data-feather="layout"></i> </div>
                <div class="menu__title">
                    Pages
                    <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="<?php if ($page == 'page-setup' || $page == 'add-new-page' || $page == 'manage-pages') {
                            echo 'menu__sub-open';
                        } ?>">
                <?php
                $page_qry = $conn->prepare("SHOW COLUMNS FROM `pages` WHERE COLUMNS.Field <> 'id'");
                $page_qry->execute();
                $page_res = $page_qry->fetchAll();
                $i = 0;
                foreach ($page_res as $pg) {
                    $page_qry_data = $conn->prepare("SELECT {$pg['Field']} FROM `pages` WHERE id=:id");
                    $page_qry_data->execute([":id" => 1]);
                    $page_res_data = $page_qry_data->fetch();
                    $fetch_page = (array)json_decode($page_res_data[$pg['Field']]);
                ?>
                    <li>
                        <a href="page-setup/<?php echo $pg['Field']; ?>" class="menu <?php if ($page == $pg['Field']) {
                                                                                                echo 'menu--active';
                                                                                            } ?>">
                            <div class="menu__icon"> <i data-feather="file"></i> </div>
                            <div class="menu__title"> <?php echo $fetch_page['title']; ?> </div>
                        </a>
                    </li>
                <?php $i++;
                } ?>
                <?php if ($i <= 7) { ?>
                    <li>
                        <a href="add-new-page" class="menu <?php if ($page == 'add-new-page') {
                                                                    echo 'menu--active';
                                                                } ?>">
                            <div class="menu__icon"> <i data-feather="file-plus"></i> </div>
                            <div class="menu__title"> Add New Page </div>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="manage-pages" class="menu <?php if ($page == 'manage-pages') {
                                                                echo 'menu--active';
                                                            } ?>">
                        <div class="menu__icon"> <i data-feather="sliders"></i> </div>
                        <div class="menu__title"> Manage Pages </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="logout" class="menu">
                <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                <div class="menu__title"> LogOut </div>
            </a>
        </li>
    </ul>
</div>
<!-- END: Mobile Menu -->
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="" class="intro-x flex justify-center items-center pl-5 pt-4">
            <img alt="Rubick Tailwind HTML Admin Template" class="" src="dist/images/logo.png" style="width: 70px;">
            <!-- <span class="hidden xl:block text-white text-lg ml-3"> ADMIN </span> -->
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'manage-gea-currency' || $page == 'manage-gea-product') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                    <div class="side-menu__title">
                        GEA Manage
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'manage-gea-currency') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="manage-gea-currency" class="side-menu <?php if ($page == 'manage-gea-currency') {
                                                                            echo 'side-menu--active';
                                                                        } ?>">
                            <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                            <div class="side-menu__title"> Manage GEA Currency </div>
                        </a>
                    </li>
                    <li>
                        <a href="manage-gea-product" class="side-menu <?php if ($page == 'manage-gea-product') {
                                                                            echo 'side-menu--active';
                                                                        } ?>">
                            <div class="side-menu__icon"> <i data-feather="zap"></i> </div>
                            <div class="side-menu__title"> Manage GEA Product </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'manage-countries' || $page == 'add-country' || $page == 'manage-country-document') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="box"></i> </div>
                    <div class="side-menu__title">
                        Countries
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'manage-countries') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="manage-countries" class="side-menu <?php if ($page == 'manage-countries') {
                                                                        echo 'side-menu--active';
                                                                    } ?>">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Manage Country </div>
                        </a>
                    </li>
                    <li>
                        <a href="add-country" class="side-menu <?php if ($page == 'add-country') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="plus-circle"></i> </div>
                            <div class="side-menu__title"> Add New Country </div>
                        </a>
                    </li>
                    <li>
                        <a href="manage-country-document" class="side-menu <?php if ($page == 'manage-country-document') {
                                                                                echo 'side-menu--active';
                                                                            } ?>">
                            <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                            <div class="side-menu__title"> Manage Country Doc. </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'manage-users') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                    <div class="side-menu__title">
                        Users
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'manage-users') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="manage-users" class="side-menu <?php if ($page == 'manage-users') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                            <div class="side-menu__title"> Manage Users </div>
                        </a>
                    </li>
                    <li>
                        <a href="user-balance" class="side-menu <?php if ($page == 'user-balance') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                            <div class="side-menu__title"> User Balance </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'manage-document' || $page == 'add-document') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="paperclip"></i> </div>
                    <div class="side-menu__title">
                        Document
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'manage-document') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="manage-document" class="side-menu <?php if ($page == 'manage-document') {
                                                                        echo 'side-menu--active';
                                                                    } ?>">
                            <div class="side-menu__icon"> <i data-feather="paperclip"></i> </div>
                            <div class="side-menu__title"> Manage Document </div>
                        </a>
                    </li>
                    <li>
                        <a href="add-document" class="side-menu <?php if ($page == 'add-document') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="file-plus"></i> </div>
                            <div class="side-menu__title"> Add New Document </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'kyc-request') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="grid"></i> </div>
                    <div class="side-menu__title">
                        KYC
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'kyc-request') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="kyc-request" class="side-menu <?php if ($page == 'kyc-request') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="grid"></i> </div>
                            <div class="side-menu__title"> KYC Request </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'manage-level' || $page == 'add-level') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="trending-up"></i> </div>
                    <div class="side-menu__title">
                        Level
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'manage-level') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <li>
                        <a href="manage-level" class="side-menu <?php if ($page == 'manage-level') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="trending-up"></i> </div>
                            <div class="side-menu__title"> Manage Level </div>
                        </a>
                    </li>
                    <li>
                        <a href="add-level" class="side-menu <?php if ($page == 'add-level') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="plus-circle"></i> </div>
                            <div class="side-menu__title"> Add New Level </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="side-menu <?php if ($page == 'page-setup' || $page == 'add-new-page' || $page == 'manage-pages') {
                                                            echo 'side-menu--active';
                                                        } ?>">
                    <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                    <div class="side-menu__title">
                        Pages
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="<?php if ($page == 'page-setup' || $page == 'add-new-page' || $page == 'manage-pages') {
                                echo 'side-menu__sub-open';
                            } ?>">
                    <?php
                    $page_qry = $conn->prepare("SHOW COLUMNS FROM `pages` WHERE COLUMNS.Field <> 'id'");
                    $page_qry->execute();
                    $page_res = $page_qry->fetchAll();
                    $i = 0;
                    foreach ($page_res as $pg) {
                        $page_qry_data = $conn->prepare("SELECT {$pg['Field']} FROM `pages` WHERE id=:id");
                        $page_qry_data->execute([":id" => 1]);
                        $page_res_data = $page_qry_data->fetch();
                        $fetch_page = (array)json_decode($page_res_data[$pg['Field']]);
                    ?>
                        <li>
                            <a href="page-setup/<?php echo $pg['Field']; ?>" class="side-menu <?php if ($page == $pg['Field']) {
                                                                                                    echo 'side-menu--active';
                                                                                                } ?>">
                                <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                                <div class="side-menu__title"> <?php echo $fetch_page['title']; ?> </div>
                            </a>
                        </li>
                    <?php $i++;
                    } ?>
                    <?php if ($i <= 7) { ?>
                        <li>
                            <a href="add-new-page" class="side-menu <?php if ($page == 'add-new-page') {
                                                                        echo 'side-menu--active';
                                                                    } ?>">
                                <div class="side-menu__icon"> <i data-feather="file-plus"></i> </div>
                                <div class="side-menu__title"> Add New Page </div>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="manage-pages" class="side-menu <?php if ($page == 'manage-pages') {
                                                                    echo 'side-menu--active';
                                                                } ?>">
                            <div class="side-menu__icon"> <i data-feather="sliders"></i> </div>
                            <div class="side-menu__title"> Manage Pages </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="logout" class="side-menu">
                    <div class="side-menu__icon"> <i data-feather="log-out"></i> </div>
                    <div class="side-menu__title"> Logout </div>
                </a>
            </li>
        </ul>
    </nav>
    <!-- END: Side Menu -->