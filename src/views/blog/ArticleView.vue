<template>
    <div class="wrapper article">
        <div>
            <span>Blog/ Поезда</span>
            <h1 class="article-title">BELMOND EASTERN & ORIENTAL EXPRESS</h1>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Delectus iure tenetur, laborum nulla dolore quibusdam tempora error sapiente aperiam eligendi voluptatem ipsa, labore aliquid magni quis ipsum sed perspiciatis veritatis at quidem libero! Architecto aut optio qui consectetur perferendis facilis dicta quisquam distinctio temporibus, perspiciatis tenetur eum magni tempore. Animi praesentium magnam cum quod voluptatum laborum, facilis asperiores officiis pariatur doloribus perferendis, beatae velit aut, quam error cumque doloremque eum quo dolor aliquid? In doloremque quos commodi. Accusantium dolorum deleniti quis, ab veritatis expedita error laboriosam rerum, exercitationem nulla mollitia sapiente porro ad neque hic provident quaerat facilis. Ad itaque aliquam veritatis voluptates nemo, fuga repudiandae accusantium illum et laboriosam, blanditiis exercitationem officia placeat suscipit adipisci consequuntur reiciendis incidunt pariatur dolorem. Ex modi ipsum cupiditate ipsam rem debitis illum eos doloribus dolorum nam, culpa iure distinctio illo sed. Quidem id, eos sed quos animi cum enim obcaecati ut nisi earum sequi culpa aliquid atque et aperiam in ratione ducimus alias facere ullam! Laudantium animi quod provident culpa consequuntur officiis aliquam exercitationem eligendi, nisi blanditiis dignissimos accusantium quaerat officia, explicabo aut expedita. Dolore sequi ratione expedita inventore veritatis repellat tempora obcaecati illum, sit, dicta velit sint assumenda officiis, soluta autem maiores.</p>
            

            <div class="add-to-my-list">
                <form>
                    <input type="text" placeholder="BELMOND EASTERN & ORIENTAL EXPRESS">
                    <input type="text" placeholder="Перу (Место)">
                    <input type="text" placeholder="Стоимость">
                    <input type="text" placeholder="Комментарий">
                    <input type="text" placeholder="Ссылка">
                    <button>Добавить в свой Bucket List</button>
                </form>
            </div>
            
        </div>
        

        

        <section class="portfolio section wow animate__animated animate__fadeInUpBig animate__slow">
            <div class="container">
                <!-- <h5 class="portfolio-subtitle active">portfolio</h5>
                <h2 class="portfolio__title title">Our Latest Work</h2> -->
        
        
                <div class="portfolio__inner">
        
                    <div class="portfolio__card">
                        <a href="work.html">
                            <div class="portfolio__card-image">
                                <img class="portfolio__card-img" src="@/assets/paris.jpg" alt="img">
                            </div>
                        
                        <div class="portfolio__card-content">
                            <h4 class="portfolio__card-title">Project</h4>
                            <p class="portfolio__card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, nemo?</p>
                        </div>
                        </a>
                    </div>
        
                    <div class="portfolio__card">
                        <a href="work.html">
                            <div class="portfolio__card-image">
                                <img class="portfolio__card-img" src="@/assets/paris.jpg" alt="img">
                            </div>
                            <div class="portfolio__card-content">
                                <h4 class="portfolio__card-title">Project</h4>
                                <p class="portfolio__card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, nemo?</p>
                            </div>
                        </a>
                    </div>
        
                    <div class="portfolio__card">
                        <a href="work.html">
                            <div class="portfolio__card-image">
                                <img class="portfolio__card-img" src="@/assets/paris.jpg" alt="img">
                            </div>
                            <div class="portfolio__card-content">
                                <h4 class="portfolio__card-title">Project</h4>
                                <p class="portfolio__card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, nemo?</p>
                            </div>
                        </a>
                    </div>
        
                </div>
        
            </div>
        </section>
        
    </div>
</template>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.article-title {
    text-align: center;
}
.add-to-my-list {
    margin-top: 50px;
}





.portfolio__inner {
  display: flex;
  justify-content: space-around;
  align-items: center; 
}

.portfolio__card {
  background-color: $active;
  text-align: center;
  border-radius: 10px;
  overflow: hidden;
  margin: 10px;
  margin-bottom: 50px;
  padding-bottom: 30px; }
  .portfolio__card-content {
    padding: 20px;
    color: #fff; 
  }
  .portfolio__card-image, .portfolio__card-title {
    margin-bottom: 20px; 
  }
  .portfolio__card-img {
    width: 100%; 
  }
  .portfolio__card-text {
    line-height: 1.8; 
  }

.portfolio-page {
  text-align: center;
  margin-bottom: 50px; 
}
  .portfolio-page__inner {
    display: flex;
}
  .portfolio-page__card {
    width: 300px;
    height: 300px;
    border-radius: 10px;
    padding: 20px;
    position: relative;
    perspective: 1000px;
    text-align: center;
    line-height: 1.8;
    margin: 20px; 
}
</style>