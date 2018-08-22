(function(window,undefined) {
    
    var onOff = true;
    var decLeng = $('.decoration-wrap .decoration-content').length
    var decHide = $('.decoration-wrap .decoration-content:nth-child(n+5)')
    if (decLeng > 3) {
        $('.decoration-more').show()
        decHide.addClass('hide')
    } else {
        $('.decoration-more').hide()
    }
    $(".decoration-more").click(function() {
        decHide.toggleClass('hide');
        // _top = setTop()
        if (onOff) {
            $(this).find('a').html('收起更多会场 <i class="icon iconfont">&#xe60f;</i>')
            onOff = false
        } else {
            $(this).find('a').html('展开更多会场 <i class="icon iconfont">&#xe610;</i>')
            onOff = true
        }
    })
    $('.decoration-wrap .decoration-content').each(function(i) {

        $(this).on("click", function() {
            $.alert($(this).find('.decoration-box').html(), "桌型摆设");
        });
    })

    // 百度地图
    var start = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0]);
    var map = new BMap.Map("placeMap");
    map.centerAndZoom(start, 13);
    map.disableDragging(); 
    map.enableScrollWheelZoom(true);
    // console.log('start', start);

    var marker = new BMap.Marker(start); // 创建标注
    map.addOverlay(marker); // 将标注添加到地图中
    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画


    var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME, BMAP_DRIVING_POLICY_LEAST_DISTANCE, BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];

    function draw(end) {
        map.clearOverlays();
        var driving = new BMap.DrivingRoute(map, {
            renderOptions: {
                map: map,
                autoViewport: true
            },
            policy: routePolicy[1]
        });
        driving.search(start, end);
    }

    /****roomlist*****/

var res={
    "errorno": 0,
    "msg": "成功",
    "data": {
        "place_id": 28432,
        "place_name": "北京天伦王朝酒店",
        "room_list": [
            {
                "house_type": "高级客房",
                "pic_list": [
                    "/pics/0/991/200104000000017y870D0_R_130_130.jpg",
                    "/pics/0/991/f4adde4fb59942ecb0f97dd490b4d8cc_R_130_130.jpg",
                    "/pics/0/991/d524870218f54e0ba95e8e303e0e1c52_R_130_130.jpg"
                ],
                "room_info": [
                    {
                        "room_id": 35946434,
                        "room_type": "团队房（间数可选）无早",
                        "bed_type": "大/双",
                        "breakfast": 0,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 834,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 833,
                                "PrePayDiscount": 66,
                                "RoomCount": 5
                            },
                            {
                                "Price": 833,
                                "PrePayDiscount": 108,
                                "RoomCount": 10
                            }
                        ],
                        "pic_url": "/pics/0/991/200104000000017y870D0_R_130_130.jpg"
                    },
                    {
                        "room_id": 10311254,
                        "room_type": "团队房（间数可选）双早",
                        "bed_type": "大/双",
                        "breakfast": 2,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 943,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 942,
                                "PrePayDiscount": 75,
                                "RoomCount": 5
                            },
                            {
                                "Price": 942,
                                "PrePayDiscount": 122,
                                "RoomCount": 10
                            }
                        ],
                        "pic_url": "/pics/0/991/200104000000017y870D0_R_130_130.jpg"
                    }
                ],
                "AreaRange": "30平方米",
                "Floor": "5-8",
                "MaxPerson": 2,
                "BedTypeList": "床型：双人床1.8米，1张或单人床1.1米，2张",
                "HasWindow": "",
                "Bathroom": "浴室：24小时热水、拖鞋、独立淋浴间、吹风机、免费洗漱用品(6样以上)、淋浴、浴室化妆放大镜、浴衣、浴缸、浴室",
                "FoodBeverages": "食品和饮品：电热水壶、咖啡壶/茶壶、小冰箱、迷你吧",
                "ConvenientFacilities": "便利设施：多种规格电源插座、中央空调、书桌、熨衣设备、220V电压插座、备用床具、客房WIFI覆盖免费、房内保险箱、房间内高速上网、雨伞、110V电压插座、闹钟、针线包、电子秤、沙发",
                "ServicesOthers": "",
                "MediaTechnology": "媒体/科技：有线频道、液晶电视机、电话、国内长途电话、国际长途电话",
                "OutdoorsViews": ""
            },
            {
                "house_type": "豪华客房",
                "pic_list": [
                    "/pics/0/991/fed37528e9514c2e9c765848f3b1e53d_R_130_130.jpg",
                    "/pics/0/991/74d91b20e853400390c9cad0d66a5174_R_130_130.jpg",
                    "/pics/0/991/200g04000000017y3B0A5_R_130_130.jpg"
                ],
                "room_info": [
                    {
                        "room_id": 21447613,
                        "room_type": "团队房（间数可选）双早",
                        "bed_type": "大床",
                        "breakfast": 2,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 1067,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 1066,
                                "PrePayDiscount": 96,
                                "RoomCount": 5
                            },
                            {
                                "Price": 1066,
                                "PrePayDiscount": 149,
                                "RoomCount": 10
                            }
                        ],
                        "pic_url": "/pics/0/991/fed37528e9514c2e9c765848f3b1e53d_R_130_130.jpg"
                    }
                ],
                "AreaRange": "30平方米",
                "Floor": "9",
                "MaxPerson": 2,
                "BedTypeList": "床型：双人床1.8米，1张或单人床1.1米，2张",
                "HasWindow": "",
                "Bathroom": "浴室：24小时热水、拖鞋、独立淋浴间、吹风机、免费洗漱用品(6样以上)、淋浴、浴室化妆放大镜、浴衣、浴缸、浴室",
                "FoodBeverages": "食品和饮品：电热水壶、咖啡壶/茶壶、小冰箱、迷你吧",
                "ConvenientFacilities": "便利设施：多种规格电源插座、中央空调、书桌、熨衣设备、220V电压插座、备用床具、客房WIFI覆盖免费、房内保险箱、房间内高速上网、雨伞、110V电压插座、闹钟、针线包、电子秤、沙发",
                "ServicesOthers": "",
                "MediaTechnology": "媒体/科技：有线频道、液晶电视机、电话、国内长途电话、国际长途电话",
                "OutdoorsViews": ""
            },
            {
                "house_type": "行政客房",
                "pic_list": [
                    "/pics/0/991/ccca10638e4c46bcaa45134a17666a27_R_130_130.jpg",
                    "/pics/0/991/33215afb3d134687be3c34cd06a192e1_R_130_130.jpg"
                ],
                "room_info": [
                    {
                        "room_id": 12593165,
                        "room_type": "团队房（间数可选）双早",
                        "bed_type": "大/双",
                        "breakfast": 2,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 1556,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 1555,
                                "PrePayDiscount": 124,
                                "RoomCount": 5
                            },
                            {
                                "Price": 1555,
                                "PrePayDiscount": 202,
                                "RoomCount": 10
                            }
                        ],
                        "pic_url": "/pics/0/991/ccca10638e4c46bcaa45134a17666a27_R_130_130.jpg"
                    }
                ],
                "AreaRange": "30平方米",
                "Floor": "10",
                "MaxPerson": 2,
                "BedTypeList": "床型：双人床1.8米，1张或单人床1.1米，2张",
                "HasWindow": "",
                "Bathroom": "浴室：24小时热水、拖鞋、独立淋浴间、吹风机、免费洗漱用品(6样以上)、淋浴、浴室化妆放大镜、浴衣、浴缸、浴室",
                "FoodBeverages": "食品和饮品：电热水壶、咖啡壶/茶壶、小冰箱、迷你吧",
                "ConvenientFacilities": "便利设施：多种规格电源插座、中央空调、书桌、熨衣设备、220V电压插座、备用床具、客房WIFI覆盖免费、房内保险箱、房间内高速上网、雨伞、110V电压插座、闹钟、针线包、电子秤、沙发",
                "ServicesOthers": "",
                "MediaTechnology": "媒体/科技：有线频道、液晶电视机、电话、国内长途电话、国际长途电话",
                "OutdoorsViews": ""
            },
            {
                "house_type": "商务套房",
                "pic_list": [
                    "/pics/0/991/200v04000000017y718DD_R_130_130.jpg"
                ],
                "room_info": [
                    {
                        "room_id": 5260,
                        "room_type": "团队房（间数可选）双早",
                        "bed_type": "大床",
                        "breakfast": 2,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 1388,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 1387,
                                "PrePayDiscount": 124,
                                "RoomCount": 5
                            }
                        ],
                        "pic_url": "/pics/0/991/200v04000000017y718DD_R_130_130.jpg"
                    }
                ],
                "AreaRange": "42平方米",
                "Floor": "5-10",
                "MaxPerson": 2,
                "BedTypeList": "床型：双人床2米，1张",
                "HasWindow": "",
                "Bathroom": "浴室：24小时热水、拖鞋、独立淋浴间、吹风机、免费洗漱用品(6样以上)、淋浴、浴室化妆放大镜、浴衣、浴缸、浴室",
                "FoodBeverages": "食品和饮品：电热水壶、咖啡壶/茶壶、小冰箱、迷你吧",
                "ConvenientFacilities": "便利设施：多种规格电源插座、中央空调、书桌、熨衣设备、220V电压插座、备用床具、客房WIFI覆盖免费、房内保险箱、房间内高速上网、雨伞、110V电压插座、闹钟、针线包、电子秤、沙发",
                "ServicesOthers": "",
                "MediaTechnology": "媒体/科技：有线频道、液晶电视机、电话、国内长途电话、国际长途电话",
                "OutdoorsViews": ""
            },
            {
                "house_type": "豪华套房",
                "pic_list": [
                    "/pics/0/991/200204000000017y7038E_R_130_130.jpg"
                ],
                "room_info": [
                    {
                        "room_id": 5261,
                        "room_type": "团队房（间数可选）双早",
                        "bed_type": "大床",
                        "breakfast": 2,
                        "wifi": "免费",
                        "price_list": [
                            {
                                "Price": 1988,
                                "PrePayDiscount": 0,
                                "RoomCount": 1
                            },
                            {
                                "Price": 1987,
                                "PrePayDiscount": 159,
                                "RoomCount": 5
                            }
                        ],
                        "pic_url": "/pics/0/991/200204000000017y7038E_R_130_130.jpg"
                    }
                ],
                "AreaRange": "76平方米",
                "Floor": "5-10",
                "MaxPerson": 2,
                "BedTypeList": "床型：双人床2米，1张",
                "HasWindow": "",
                "Bathroom": "浴室：24小时热水、拖鞋、独立淋浴间、吹风机、免费洗漱用品(6样以上)、淋浴、浴室化妆放大镜、浴衣、浴缸、浴室",
                "FoodBeverages": "食品和饮品：电热水壶、咖啡壶/茶壶、小冰箱、迷你吧",
                "ConvenientFacilities": "便利设施：多种规格电源插座、中央空调、书桌、熨衣设备、220V电压插座、备用床具、客房WIFI覆盖免费、房内保险箱、房间内高速上网、雨伞、110V电压插座、闹钟、针线包、电子秤、沙发",
                "ServicesOthers": "",
                "MediaTechnology": "媒体/科技：有线频道、液晶电视机、电话、国内长途电话、国际长途电话",
                "OutdoorsViews": ""
            }
        ]
    }
}

    //var id=location.href.match(/\/\d+/)[0].replace('/','');
    // var roomApi='/api/room/getList?place_id=28432';

    // $.get(roomApi,function(){

    //     if(res.errorno===0){
    //         creatRoomVM(res.data.room_list.room_info)
    //     }

    // })




    //console.log(res.data.room_list)

 




})(window,undefined)