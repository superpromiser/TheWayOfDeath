<template>
  <v-container v-touch="{
    left: () => swipe('Left'),
    right: () => swipe('Right'),
  }">
      <v-row class="ma-0">
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
  </v-container>
</template>

<script>
export default {
    data: ()=> ({
        baseUrl: window.Laravel.base_url,
    }),

    methods:{
      swipe (direction) {
        if(direction == "Left"){
          this.$router.push({name: 'profile.list'});
        }
        if(direction == "Right"){
          this.$router.push({name: 'mochat.news'});
        }
      },
    }
}
</script>

<style>

</style>