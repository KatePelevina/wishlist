<template>
    <div class="page">
        <h1>MyChecklist.vue</h1>
        <h3>Dubai</h3>
        <!-- <ul>
            <li>Miracle Garden (Чудо-сад)</li>
            <li>Palm Islands (Пальмовые острова)</li>
        </ul> -->

        <a href="https://ru.pinterest.com/pin/68745569431/">Dubai bucket list</a>
        <div class="input">
            <input type="checkbox">Miracle Garden (Чудо-сад)
        </div>
        <div class="input">
            <input type="checkbox">Palm Islands (Пальмовые острова)
        </div>
        <div class="input">
            <input type="checkbox">Дубай Марина 
        </div>
        <div class="input">
            <input type="checkbox">Бурдж-Халифа (Burdž Kalifa)
        </div>
        <div class="input">
            <input type="checkbox">Фонтан Дубай
        </div>
        <div class="input">
            <input type="checkbox">Wild Wadi Waterpark Dubai (водный парк развлечений)
        </div>
        <div class="input">
            <input type="checkbox">Полет на вертолете над Дубаем
        </div>
        <div class="input">
            <input type="checkbox">Ресторан Ossiano  с огромным панорамным аквариумом
        </div>
        <div class="input">
            <input type="checkbox"> Подайвить с акулами
            <a href="https://ru.oddviser.com/emirates/dubai/shark-dive">https://ru.oddviser.com/emirates/dubai/shark-dive</a>
        </div>
        <div class="input">
            <input type="checkbox">Полетать на воздушном шаре 
            <a href="https://www.getyourguide.com/-l173/-tc47/?cmp=ga&cq_src=google_ads&cq_cmp=6654623935&cq_con=77193820977&cq_term=hot%20air%20balloon%20dubai&cq_med=&cq_plac=&cq_net=g&cq_pos=&cq_plt=gp&campaign_id=6654623935&adgroup_id=77193820977&target_id=aud-607387271913%3Akwd-294870765582&loc_physical_ms=1028591&match_type=b&ad_id=628280306821&keyword=hot%20air%20balloon%20dubai&ad_position=&feed_item_id=&placement=&device=c&partner_id=CD951&gclid=CjwKCAjwgqejBhBAEiwAuWHioOpfDFHLzyvkk9DRPR3yU0ivn0unSjfuPks3wSfFVTtGLhGUwmC2ahoC4TYQAvD_BwE">Ссылка</a>
        </div>
        <div class="input">
            <input type="checkbox">Лодка Abra
            <a href="https://www.tripadvisor.com/Attraction_Review-g295424-d1436120-Reviews-Bur_Dubai_Abra_Station-Dubai_Emirate_of_Dubai.html">Ссылка</a>
        </div>    
    </div>
</template>

<style scoped lang="scss">
@import "@/styles/_variables.scss";
.input {
    display: block;
}
.page {
    @include page;
}
</style>