# acrit.exportproplus-wb-color-and-sizes-mod
Модификация экспорта в Wildberries (API v3) для модуля "Акрит - Экспорт на порталы + API" (Цвет - номенклатура, размер - вариации).

Данная модификация решает проблему выгрузки в Wildberries торговых предложений разного цвета и размера в одну карточку товара.

В терминах Акрита в итоге мы получим выгрузку в таком формате:

**Карточка (Товар [Туфли])**
- Номенклатура (Торговое предложение [*Цвет: черный*])
  - Вариация (Торговое предложение [*Размер: 35*])
  - Вариация (Торговое предложение [*Размер: 36*])
  - Вариация (Торговое предложение [*Размер: 37*])
  - Вариация (Торговое предложение [*Размер: 38*])
- Номенклатура (Торговое предложение [*Цвет: красный*])
  - Вариация (Торговое предложение [*Размер: 36*])
  - Вариация (Торговое предложение [*Размер: 38*])
  - Вариация (Торговое предложение [*Размер: 41*])
