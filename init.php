<?php

if (\Bitrix\Main\Loader::includeModule('acrit.exportproplus')) {
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'acrit.exportproplus',
        'onUpBuildJson',
        function ($obPlugin, &$arItem, &$arElement, &$arFields, &$arElementSections, &$arDataMore) {
            if ($obPlugin->getCode() == "WILDBERRIES_V3") {
                $bOffer = \Acrit\Core\Helper::isOffersIBlock($arElement['IBLOCK_ID']);
                if ( ! $bOffer) {
                    $ColorsAndVariations = array();
                    foreach ($arItem["nomenclatures"] as $key => &$Nomenclature) {
                        if (isset($Nomenclature["addin"])) {
                            foreach ($Nomenclature["addin"] as &$addin) {
                                if ($addin["type"] == "Основной цвет") {
                                    $addin["params"][0]["value"] = mb_strtolower($addin["params"][0]["value"]);
                                    $Nomenclature["vendorCode"]  = $addin["params"][0]["value"];
                                    $color_key                   = array_search($addin["params"][0]["value"], array_column($ColorsAndVariations, 'color'));
                                    if ($color_key !== false) {
                                        # Remove duplicate sizes
                                        $SizeFl = false;
                                        foreach ($Nomenclature["variations"] as $Variation) {
                                            foreach ($Variation["addin"] as $Variation_addin) {
                                                if ($Variation_addin["type"] == "Размер") {
                                                    foreach ($ColorsAndVariations[$color_key]["variations"] as $ColorVariation) {
                                                        foreach ($ColorVariation["addin"] as $Color_addin) {
                                                            if ($Color_addin["type"] == "Размер") {
                                                                if ($Variation_addin["params"][0]["value"] == $Color_addin["params"][0]["value"]) {
                                                                    $SizeFl = true;
                                                                    break 4;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if ( ! $SizeFl) {
                                            $ColorsAndVariations[$color_key]["variations"] = array_merge($ColorsAndVariations[$color_key]["variations"], array_values($Nomenclature["variations"]));
                                        }
                                        unset($arItem["nomenclatures"][$key]);
                                    } else {
                                        $ColorsAndVariations[]["color"]                                     = $addin["params"][0]["value"];
                                        $ColorsAndVariations[count($ColorsAndVariations) - 1]["index"]      = $key;
                                        $ColorsAndVariations[count($ColorsAndVariations) - 1]["variations"] = $Nomenclature["variations"];
                                    }
                                    break;
                                }
                            }
                        }
                    }

                    foreach ($ColorsAndVariations as $ColorsAndVariation) {
                        $arItem["nomenclatures"][$ColorsAndVariation["index"]]["variations"] = array_values($ColorsAndVariation["variations"]);
                    }
                    $arItem["nomenclatures"] = array_values($arItem["nomenclatures"]);
                }
            }
        }
    );
}
