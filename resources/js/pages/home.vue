<template>
  <v-container>
    <v-row>
      <v-col v-for="(schoolItem, i) in schoolData" :key="i" cols="12" md="4" sm="6">
        <v-card>
          <v-img :src="`${baseUrl}${schoolItem.imgUrl}`" alt="school" class="school-card-img"></v-img>
          <v-card-title>{{schoolItem.schoolName}}</v-card-title>
          <v-card-text>
            <v-row
              align="center"
              class="mx-0"
            >
              <v-rating
                :value="4.5"
                color="amber"
                dense
                half-increments
                readonly
                size="14"
              ></v-rating>

              <div class="grey--text ml-4">
                4.5 (413)
              </div>
            </v-row>

            <div class="my-2 subtitle-1 d-flex align-center">
              <v-icon class="mr-2">mdi-account</v-icon>
              <span><strong>{{schoolItem.head}}</strong></span>
            </div>

            <div class="my-2 subtitle-1 d-flex align-center">
              <v-icon class="mr-2">mdi-phone-hangup</v-icon>
              <span><strong>{{schoolItem.phoneNum}}</strong></span>
            </div>

            <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    
  </v-container>
</template>

<script> 
import { getSchool } from '~/api/school'
export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    baseUrl: window.Laravel.base_url,
    schoolData : [],
    isLoadingSchoolData : false,
  }),

  async created(){
    this.isLoadingSchoolData = true;
    getSchool()
      .then((res) => {
        this.schoolData = res.data;
        this.isLoadingSchoolData = false;
      }).catch((err) => {
        //console.log(err);
        this.isLoadingSchoolData = false;
      });
  },
}
</script>
