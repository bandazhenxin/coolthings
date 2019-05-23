# cool things 
## __一起做有意义的事__

    酷事就是让大家开心、让自己开心、又有意义的事。
  
    cool things是一款应用，我将使用它跟我的朋友们一起互动、一起做酷事。
  
  
  
## __应用简介__
    朋友们可以在cool things上匿名发布自己觉得很酷的事，比如“在街头卖唱”。
    
    有才华的朋友看见这条cool things后选择去实现，并把成果在cool things上晒出。
    
    如果你觉得挺好玩,可以加入我们一起开发，开发也是一件很酷的事嘛。
  

![一起做有意义的事](http://www.17wanzhuan.com/public/admin/images/meow.jpg)



## __框架__
    本项目没有使用任何主流框架，而是使用composer集成、个人架构的一个轻型框架。
    框架完全放弃使用控制器渲染页面，页面静态化，前后端分离，纯api交互。
  
    还是想种草我的这个框架。
  
1. 本框架与本项目同名，cool things;
2. MSC结构，model层、service层、controller层，页面静态化的后端当然没有view层了，想啥呢;
3. 路由直接在配置文件config目录下route.php里写数组就行；
4. controller层负责数据获取和验证，以及统筹调用service层业务;
5. service层负责对应职责的业务并与服务器数据（如数据库）交互;
6. controller层只能调用service空间下同目录下的service层；
7. 建议一个controller只有一个主要的service层，复杂的业务都交给主service层；
8. service层与controller层的调用在本框架下进行了解耦操作，用调用数组的方法调用sevice层

9、10、11巴拉巴拉

    总而言之，我设计并实现的cool things框架是一个清新、简洁、优雅的框架^^。
    cool things框架还是个孩子，我希望能有小伙伴加入一起让它成长。

## __注意__
    本框架遵循极简的原则（其实是怕费事），所以我们只使用mysql！且！每个数据表的主键名只用"id"。
    如果强行使用其它名字也可以勉强，但是有时候会出抛错的==
    
    现在正在开发移动web版，后期逐步发布单页面版、微信小程序版。
