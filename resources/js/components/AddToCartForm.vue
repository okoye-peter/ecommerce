<template>
    <div>
        <form :action="action" v-on:submit.prevent="add_to_cart" method="post">
            <button>
                Add
                <i class="fa fa-cart-plus"></i>
            </button>
        </form>
    </div>
</template>

<script>
export default {
  props:{
    action: {
      type: String,
      required: true
    }
  },
  data(){
    return {
      width: 100,
      x: false,
      y: 0
    }
  },
  computed:{

  },

  methods: {
    // toggleAlert(alt){
    //       alt.classList.add('active');
    //       let div = document.getElementById('alert');
    //       let timer = div.querySelector('.time');
    //       ++this.y
    //       if (timer.style.width === '0%' && this.y >= 325) {
    //         this.width = 100;
    //         this.y = 0;
    //         alt.classList.remove('active');
    //         timer.style.width = '100%';
    //         clearInterval(this.x);
    //         this.x = false;
    //       }else{
    //         this.width = this.width - 1;
    //         timer.style.width = this.width + "%";
    //         timer.style.width = this.width + '%';
    //       }
    //       console.log('still on');
    // },

    add_to_cart(event) {
      axios
        .post(this.action, {})
        .then(response => {
          document.querySelector("#vue-cart-products-count").innerHTML = response.data;
      
          createAlert(event.target.parentNode.previousElementSibling.firstChild.children[1].textContent);
        })
        .catch(error => {
          if (error) {
            console.log(error);
            window.location.assign("/login");
          }
        });
    },
    
  }
};
</script>

<style scoped>
button {
    position: absolute;
    top: 14.6em;
    right: 0.5em;
    background: yellowgreen;
    outline: none;
    border: 0;
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    transition: all 1s;
    color: white;
}
button:hover {
    background: #38c172;
}
</style>
