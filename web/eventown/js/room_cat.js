
Vue.filter('formatBreakfast', function(val) {

    if (val == 1) {
        return '单早'
    }
    if (val == 2) {
        return '双早'
    }
    return '无早'

})


var roomCat = (function() {
    var CartVM = null

    var getLocalStore = (function() {
        var loc = window.localStorage.getItem('cartStor');
        console.log(loc)
        if (loc) {
            return $.parseJSON(loc)
        }
        return false
    })()


    function getData() {
        if (getLocalStore) {
            $.get('/api/room/getListByIds', { ids: getLocalStore }, function(res) {
                $('#loading').hide();
                createVM(res.data)
            })
        } else {
            $('#loading').hide()

        }
    }

    function saveLoc(data) {



        var obj = {};
        $.each(data, function(k, v) {
            $.each(v.roomList, function(i, o) {
                obj[o.room_id] = o.room_id + ',' + v.place_id + ',' + o.number + ',' + o.checkin + ',' + o.checkout
            })
        })
        window.localStorage.setItem('cartStor', JSON.stringify(obj))
    }

    function PrePayDiscount(endNumber) {

        if (endNumber >= 5 && endNumber < 10) {
            return 1
        } else if (endNumber >= 10) {
            return 2
        } else {
            return 0
        }
    }
    //ssssss
    function computedPice(item, index) {

        var cPrice = item.price_list[index]
        item.price = cPrice.Price - cPrice.PrePayDiscount
        item.discount = cPrice.PrePayDiscount

    }

    function computedTotalPrice(data) {
        var price = 0;
        $.each(data, function(k, v) {
            $.each(v.roomList, function(i, o) {
                if (o.checked) {
                    price += parseInt(o.price) * parseInt(o.number)
                }
            })
        })
        console.log(price)
        CartVM.totalPrice = price

        return price


    }



    function createVM(data) {

        CartVM = new Vue({
            el: 'body',
            data: {
                list: data
            },
            ready: function() {
                roomCat.editer();
                // roomCat.checkedAll_box();
                // roomCat.radio_checked();
                // roomCat.checkedAll();
            },
            methods: {
                toggleCheck:function(rootIndex,index){
 this.list[rootIndex].roomList[index].checked = !this.list[rootIndex].roomList[index].checked

                },
                add: function(rootIndex, index) {

                    this.list[rootIndex].roomList[index].number = parseInt(this.list[rootIndex].roomList[index].number) + 1
                    var endNumber = this.list[rootIndex].roomList[index].number;


                    computedPice(this.list[rootIndex].roomList[index], PrePayDiscount(endNumber));

                    computedTotalPrice()
                },
                reduce: function(rootIndex, index) {
                    var currentNumber = this.list[rootIndex].roomList[index].number;
                    if (currentNumber <= 1) {
                        return
                    }
                    this.list[rootIndex].roomList[index].number = parseInt(currentNumber) - 1;

                    var endNumber = this.list[rootIndex].roomList[index].number;
                    computedPice(this.list[rootIndex].roomList[index], PrePayDiscount(endNumber))
                    computedTotalPrice()

                    //满减切换

                },
                remove: function(rootIndex, index) {

                    this.list[rootIndex].roomList.splice(index, 1);
                    if (this.list[rootIndex].roomList.length == 0) {
                        this.list.splice(rootIndex, 1)

                    }
                    console.log(this.list)

                },
                submitOrder: function() {
                    /*$.post('/order',{data:this.$data.list},function(res){
                        //跳转到订单确认页。。。
                        if(res.errorno==0){
                            location.href=''
                        }

                    })*/
                    var cart_data = this.$data.list;
                    var cart_list = { 'place_id': [], 'room_id': [], 'number': [], 'checkin': [], 'checkout': [], price: '', count: '' };
                    if (cart_data.length > 0) {
                        $.each(cart_data, function(k, v) {
                            $.each(v.roomList, function(key, val) {
                                if (val.checked == true) {
                                    cart_list.place_id.push(val.place_id);
                                    cart_list.room_id.push(val.room_id);
                                    cart_list.number.push(val.number);
                                    cart_list.checkin.push(val.checkin);
                                    cart_list.checkout.push(val.checkout);
                                }
                            })
                        })
                        cart_list.price = this.totalPrice;
                        cart_list.count = this.totalRoom;
                        if(cart_list.place_id.length != 0){
                            window.localStorage.setItem('cart_list', JSON.stringify(cart_list));
                            window.location.href = '/room/cartform';
                        }else{
                            $.alert('请选择商品到下一步！');
                        }
                    }

                }

            },
            computed: {
                totalPrice: function() {
                    var price = 0;

                    $.each(this.list, function(k, v) {
                        $.each(v.roomList, function(i, o) {
                            if (o.checked) {
                                price += parseInt(o.price) * parseInt(o.number)
                            }
                        })
                    })

                    // alert(price)

                    saveLoc(this.$data.list)
                    return price



                },
                totalRoom: function() {
                    var count = 0
                    $.each(this.list, function(k, v) {

                        $.each(v.roomList, function(i, o) {
                            if (o.checked) {
                                count += parseInt(o.number)
                            }
                        })

                    })
                    return count
                }
            }
        })

    }



    return roomCart = {
        init: function() {
            $('#loading').show()
            getData()
        },
        editer: function() {
            $('.editor').each(function() {
                var active = $(this).attr('data-active')
                $(this).on('click', function() {
                    if (active) {
                        $(this).html('完成')
                        var _parent = $(this).parents('.cart-area')
                        _parent.find('.cart-info-default').hide()
                        _parent.find('.cart-info-hide').show()
                        _parent.find('.cart-del').addClass('cart-del-show');
                        active = false;
                    } else {
                        $(this).html('编辑')
                        var _parent = $(this).parents('.cart-area')
                        _parent.find('.cart-info-default').show()
                        _parent.find('.cart-info-hide').hide()
                        _parent.find('.cart-del').removeClass('cart-del-show')
                        active = true;
                    }
                })
            });
        }
      
    }
}())

roomCat.init();
