<template>
	<div class="modal" :class="openmodal">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Add Item</p>
	      <button class="delete" aria-label="close" @click="close"></button>
	    </header>

	    <section class="modal-card-body">
	    	<div class="field">
			  <label class="label">Name</label>
			  <div class="control">
			    <input class="input" v-bind:class="{'is-danger':errors.name}" type="text" placeholder="Name" v-model="list.name">
			  </div>
			  <small v-if="errors.name" class="has-text-danger">{{errors.name[0]}}</small>
			</div>

			<div class="field">
			  <label class="label">Phone</label>
			  <div class="control">
			    <input class="input" v-bind:class="{'is-danger':errors.phone}" type="number" placeholder="Phone" v-model="list.phone">
			  </div>
			  <small v-if="errors.phone" class="has-text-danger">{{errors.phone[0]}}</small>
			</div>

			<div class="field">
			  <label class="label">Email</label>
			  <div class="control">
			    <input class="input" v-bind:class="{'is-danger':errors.email}" type="email" placeholder="Email" v-model="list.email">
			  </div>
			  <small v-if="errors.email" class="has-text-danger">{{errors.email[0]}}</small>
			</div>
	    </section>

	    <footer class="modal-card-foot">
	      <button class="button is-success" @click="save">
	      	<span class="icon is-small">
      			<i class="fa fa-check"></i>
    		</span>
    		<span>Save</span>
	      </button>
	      <button class="button is-outlined is-danger" @click="close">Cancel</button>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default{
		props:['openmodal'],
		data(){
			return{
				list: {
					name:'',
					phone:'',
					email:''
				},
				errors:''
			}
		},
		methods:{
			close(){
				this.$emit('closeRequest');
				this.list.name = '';
				this.list.phone = '';
				this.list.email = '';
			},
			save(){
				axios.post('/phonebook',this.$data.list)
					 .then(res => {
					 	this.close();
					 	this.$parent.lists.push(res.data);
					 	this.$parent.lists.sort((a,b) => a.name>b.name?1:-1);					 	
					 })			
					 .catch(err => this.errors = err.response.data.errors);
			}
	}
}
</script>