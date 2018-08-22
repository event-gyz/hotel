/***城市弹出层**/
define(function(require,exports,module){
	function cityLayer(target,elem,opt){
		this.idBox=elem;
		this.el=$(elem);
		this.target=$(target);
		this.defautOpt={
			autoBind:true,
			hotURL:'/index.php/placeinfo/get-city-list',
			dataURL:'/index.php/placeinfo/get-city-list-by-zm?zm='
		}
		this.opt=$.extend(this.defautOpt,opt)
		console.log(this.opt)
		this.init();
		this.fn=null;
		this.hot=true;
		this.bindEvt();
	}

	cityLayer.prototype={
		init:function() {
			this.createDom();
		},
		createDom:function(){ //创建layer 层 导航
			var html='<div class="cityNav">'+
			        '<span class="active" id="hot" cdata="false">热门</span>'+
			        '<span class="" id="a" key="a" cdata="false">ABCD</span>'+
			        '<span class="" id="b" key="e" cdata="false">EFGH</span>'+
			        '<span class="" id="c" key="j" cdata="false">JKLM</span>'+
			        '<span class="" id="d" key="n" cdata="false">NOPQRS</span>'+
			        '<span class="" id="e" key="t" cdata="false">TUVWX</span>'+
			        '<span class="" id="f" key="y" style="margin-right: 0;" cdata="false">YZ</span>'+
			        '</div><div class="cityList">'+
			        '</div>';
			this.el.append(html);
		},
		getData:function(id,key){ //根据点击节点不同选择不同的方法与url
			var url,_this=this;
			if(typeof key == 'undefined'){
				url=this.opt.hotURL;
				this.fn=this.hotData;
			}else{
				url=this.opt.dataURL+key;
				this.fn=this.cityData;
			}
			$.ajax({
				type:'get',
				url:url,
				success:function(data){
					_this.fn(data,id);
				}
			})
		}, 
		hotData:function(data,id){  //获取热门城市数据
			if($('#'+id+'_box').length>0){	
				this.tab('#'+id+'_box');
			}else{
				this.tab();
				var nData=eval(data);
				if(nData.length>0){
					var html=$('<div class="cityName" style="display:block;" id="'+id+'_box"><ul></ul></div>'),oLi='';
					for(var i=0,n=nData.length; i<n; i++){
						oLi+='<li data-city_id="'+nData[i].areaid+'">'+nData[i].name+'</li>';
					}
					html.find('ul').append(oLi);
					this.el.find('.cityList').append(html);
				}
			}
		},
		cityData:function(data,id){  //获取其它城市数据
			if($('#'+id+'_box').length>0){
				this.tab('#'+id+'_box');
			}else{
				this.tab();
				if(typeof data=='string' && data==''){return false;}
				var vData=eval('('+data+')'); 
				var html=$('<div class="cityName" style="display:block;" id="'+id+'_box"></div>'),oDl='<dl>';
				for(var key in vData){
					oDl+='<dt>'+key+'</dt><dd><ul>';
					for(var xm in vData[key]){
						oDl+='<li data-city_id="'+vData[key][xm].areaid+'">'+vData[key][xm].name+'</li>';
					}
					oDl+='</ul></dd>';
				}
				oDl+='</dl>';
				html.append(oDl);
				this.el.find('.cityList').append(html);
			}
		},
		show:function(){  
			this.el.show()
		},
		hide:function(){
			this.el.hide()
		},
		tab:function(id){
			this.el.find('.cityList').find('.cityName').each(function(){
				$(this).hide();
			})
			if(typeof id != 'undefined'){
				$(id).show();
			}
		},

		changeUrl:function(){
	        var defaultStr='0-0-0-0-0-0-0-0-0-0-room-0-0-0-0';
	        var href=window.location.href,hArr;
	        hArr=href.split('search/');
	        if(hArr.length>1){
	            var last=hArr[hArr.length-1];
	            var opt=last.split('-');
	            if(last.indexOf('-') !=-1 && opt.length==15){
	                return opt.join('-');
	            }
	        }
	        return defaultStr; 
		},

		idAttr:function(obj){
			var id=$(obj).attr('data-city_id');
			var txt=$(obj).text();
			if(id!=undefined){
				$(this.opt.hiddenInput).val(id).attr('cityName',txt);
				$(this.target).val(txt);
				this.hide();
				var url=this.changeUrl();

				console.log(url);
				opt=url.split('-');
				opt[0]=id;
				opt[12]=0;
				window.location.href='/room/search/'+opt.join('-');
				// window.location=opt.join('-')
			}
		},
		bindEvt:function(){
			var _this=this;
			this.el.click(function(e){ //阻止点击空白时冒泡消失
				var elem=e.target;
				_this.idAttr(elem)
				return false;
			})
			this.target.click(function(e){
				return false;
			})
			$(this.opt.triggerElem).click(function(){
				_this.show();
				if(_this.hot){
					_this.getData('hot');
				}
				_this.hot=false;
				return false;
			})
			this.target.focus(function(){
				_this.show();
				if(_this.hot){
					_this.getData('hot');
				}
				_this.hot=false;
				return false;
			})
			this.target.blur(function(){
				// _this.hide();
			})
			$(document).click(function(){
				_this.hide();
			})
			this.el.find('.cityNav').find('span').click(function(){
				var key=$(this).attr('key');
				var dataYn=$(this).attr('cdata');
				var id=$(this).attr('id');
				$(this).addClass('active').siblings().removeClass('active');
				if(dataYn == 'false'){
					_this.getData(id,key);
					$(this).attr('cdata','true');
				}else{
					_this.tab('#'+id+'_box');
				}
				return false;
			})			
		}
		
	}
	module.exports={
		'cityLayer':function(target,elem,opt){
			return new cityLayer(target,elem,opt)
		},
		'idArr':cityLayer.idArr
	}
})


