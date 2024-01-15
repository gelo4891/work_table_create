<?php
  $menuData = [
    [
        "title" => "Home",
        "link" => "/home",
    ],
    [
        "title" => "About",
        "link" => "/about",
    ],
    [
        "title" => "Products",
        "link" => "/products",
        "submenu" => [
            [
                "title" => "Product 1",
                "link" => "/product-1",
            ],
            [
                "title" => "Product 2",
                "link" => "/product-2",
                "submenu" => [
                    [
                        "title" => "Subproduct 1",
                        "link" => "/subproduct-1",
                    ],
                    [
                        "title" => "Subproduct 2",
                        "link" => "/subproduct-2",
                    ],
                ],
            ],
            [
                "title" => "Product 3",
                "link" => "/product-3",
            ],
        ],
    ],
    [
        "title" => "Contact",
        "link" => "/contact",
    ],
];


$menuData2 = array(
    array(
        "title" => "Home11111111",
        "link" => "/home"
    ),
    array(
        "title" => "About11111111",
        "link" => "/about"
    ),
    array(
        "title" => "Products111111111",
        "link" => "/products",
        "submenu" => array(
            array(
                "title" => "Product 1",
                "link" => "/product-1"
            ),
            array(
                "title" => "Product 2",
                "link" => "/product-2",
                "submenu" => array(
                    array(
                        "title" => "Subproduct 1",
                        "link" => "/subproduct-1"
                    ),
                    array(
                        "title" => "Subproduct 2",
                        "link" => "/subproduct-2"
                    )
                )
            ),
            array(
                "title" => "Product 3",
                "link" => "/product-3"
            )
        )
    ),
    array(
        "title" => "Contact",
        "link" => "/contact"
    )
);


$menuData3 = array(
    array(
        "title" => "Home",
        "link" => "/",
        "attrs" => array(
            "class" => "home-link",
            "id" => "home-link"
        )
    ),
    array(
        "title" => "About",
        "link" => "/about",
        "attrs" => array(
            "class" => "about-link",
            "id" => "about-link"
        ),
        "submenu" => array(
            array(
                "title" => "History",
                "link" => "/about/history",
                "attrs" => array(
                    "class" => "history-link",
                    "id" => "history-link"
                )
            ),
            array(
                "title" => "Team",
                "link" => "/about/team",
                "attrs" => array(
                    "class" => "team-link",
                    "id" => "team-link"
                )
            )
        )
    ),
    array(
        "title" => "Services",
        "link" => "/services",
        "attrs" => array(
            "class" => "services-link",
            "id" => "services-link"
        )
    ),
    array(
        "title" => "Contact",
        "link" => "/contact",
        "attrs" => array(
            "class" => "contact-link",
            "id" => "contact-link"
        )
    )
);

$menuData4 = array(
    array(
        "title" => "Home",
        "link" => "/",
        "accessLevel" => 0 // приклад рівня доступу (0 - найвищий рівень доступу)
    ),
    array(
        "title" => "Products",
        "link" => "/products",
        "submenu" => array(
            array(
                "title" => "Product 1",
                "link" => "/products/1",
                "accessLevel" => 1 // приклад рівня доступу (1 - рівень доступу для підпункту)
            ),
            array(
                "title" => "Product 2",
                "link" => "/products/2"
            ),
            array(
                "title" => "Product 3",
                "link" => "/products/3"
            )
        )
    ),
    array(
        "title" => "About Us",
        "link" => "/about-us"
    ),
    array(
        "title" => "Contact Us",
        "link" => "/contact-us"
    )
);



?>