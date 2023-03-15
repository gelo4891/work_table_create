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

?>