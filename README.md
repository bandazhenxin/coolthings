# cool things 
## __一起做有意义的事__
  什么样的事才叫“酷事”，在“酷事”的webapp（后期逐渐推小程序、单页面）上匿名发布你认为的酷事，让大家一起来做这件很酷的事。你可以欣赏有才能的人并选择认识ta，可以认识所有一起做酷事的朋友。这个webapp暂时只给我的朋友们使用，希望能跟他们一起做有意义的事。也欢迎开发者的加入，一起码代码也很酷！
  
  
## __框架__
  本项目没有使用任何主流框架，而是使用composer集成、架构的一个个人轻型框架。框架完全放弃使用控制器渲染页面，静态化页面，前后端分离。后端使用api与前端交互。
  
  还是安利一下我的这个框架吧。
1. 本框架名称暂定与本项目同名，很酷;
2. MSC结构，model层、service层、controller层，页面静态化的后端当然没有view层了，想啥呢;
3. laravel的路由是每个都需要定义，否则不能访问，我的也是^^。但是没有那么麻烦，直接在配置文件config——route.php里写数组就行；
4. controller层负责数据获取和验证，以及统筹调用service层业务;
5. service层负责对应职责的业务并与服务器数据（如数据库）交互;
6. controller层只能调用service空间下同目录下的service层；
7. 建议一个controller只有一个主要的service，复杂的业务都交给主service，只有当其它service有更直接便捷的方法时才可以调用，否则与其它service层的交互都交给本service层处理；
8. service层的调用在本框架下进行了解耦操作，只要初始化api基类后使用$this->service调用数组的方式调用同名service层即可，这个操作是核心中的核心，等有小伙伴一起开发后悔详细告诉ta使用方法，这一块是我的得意之作

## __注意__
  本框架遵循极简的原则（其实是怕费事），所以我们只使用mysql！且！每个数据表的主键名只用"id"。如果强行使用其它名字也可以勉强，但是有时候会出抛错的哦，别怪我没有提醒==
