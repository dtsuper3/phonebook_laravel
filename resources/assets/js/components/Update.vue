<template>
	<div class="modal" :class="openmodal">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Update {{ list.name }}'s Details</p>
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
      			<i class="fa fa-edit"></i>
    		</span>
    		<span>Update</span>
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
				list: {	},
				errors:''
			}
		},
		methods:{
			close(){
				this.$emit('closeRequest');
				this.$data.list.name = '';
				this.$data.list.phone = '';
				this.$data.list.email = '';
			},
			save(){
				axios.patch(`/phonebook/${this.list.id}`,this.$data.list)
					 .then(res => this.close())
					 .catch(err => this.errors = err.response.data.errors);
			}
	}
}
</script>