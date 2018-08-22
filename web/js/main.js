// 创建省、城市列表
var provinceList = ['北京市', '天津市', '河北省', '山西省', '内蒙古自治区', '辽宁省', '吉林省', '黑龙江省', '上海市', '江苏省', '浙江省', '安徽省', '福建省', '江西省', '山东省', '河南省', '湖北省', '湖南省', '广东省', '广西壮族自治区', '海南省', '重庆省', '四川省', '贵州省', '云南省', '西藏自治区', '陕西省', '甘肃省', '青海省', '宁夏回族自治区', '新疆维吾尔自治区', '台湾省', '香港特别行政区', '澳门特别行政区'],
    cityList = [
        ['北京市'],
        ['天津市'],
        ['石家庄市', '唐山市', '秦皇岛市', '邯郸市', '邢台市', '保定市', '张家口市', '承德市', '沧州市', '廊坊市', '衡水市', '省直辖市'],
        ['太原市', '大同市', '阳泉市', '长治市', '晋城市', '朔州市', '晋中市', '运城市', '忻州市', '临汾市', '吕梁市'],
        ['呼和浩特市', '包头市', '乌海市', '赤峰市', '通辽市', '鄂尔多斯市', '呼伦贝尔市', '巴彦淖尔市', '乌兰察布市', '兴安盟', '锡林郭勒盟', '阿拉善盟'],
        ['沈阳市', '大连市', '鞍山市', '抚顺市', '本溪市', '丹东市', '锦州市', '营口市', '阜新市', '辽阳市', '盘锦市', '铁岭市', '朝阳市', '葫芦岛市'],
        ['长春市', '吉林市', '四平市', '辽源市', '通化市', '白山市', '松原市', '白城市', '延边朝鲜族自治州'],
        ['哈尔滨市', '齐齐哈尔市', '鸡西市', '鹤岗市', '双鸭山市', '大庆市', '伊春市', '佳木斯市', '七台河市', '牡丹江市', '黑河市', '绥化市', '大兴安岭地区'],
        ['上海市'],
        ['南京市', '无锡市', '徐州市', '常州市', '苏州市', '南通市', '连云港市', '淮安市', '盐城市', '扬州市', '镇江市', '泰州市', '宿迁市'],
        ['杭州市', '宁波市', '温州市', '嘉兴市', '湖州市', '绍兴市', '金华市', '衢州市', '舟山市', '台州市', '丽水市'],
        ['合肥市', '芜湖市', '蚌埠市', '淮南市', '马鞍山市', '淮北市', '铜陵市', '安庆市', '黄山市', '滁州市', '阜阳市', '宿州市', '六安市', '毫州市', '池州市', '宜城市'],
        ['福州市', '厦门市', '莆田市', '三明市', '泉州市', '漳州市', '南平市', '龙岩市', '宁德市'],
        ['南昌市', '景德镇市', '萍乡市', '九江市', '新余市', '鹰潭市', '赣州市', '吉安市', '宜春市', '抚州市', '上饶市'],
        ['济南市', '青岛市', '淄博市', '枣庄市', '东营市', '烟台市', '潍坊市', '济宁市', '泰安市', '威海市', '日照市', '莱芜市', '临沂市', '德州市', '聊城市', '滨州市', '菏泽市'],
        ['郑州市', '开封市', '洛阳市', '平顶山市', '安阳市', '鹤壁市', '新乡市', '焦作市', '濮阳市', '许昌市', '漯河市', '三门峡市', '南阳市', '商丘市', '信阳市', '周口市', '驻马店市', '省直辖县'],
        ['武汉市', '黄石市', '十堰市', '宜昌市', '襄阳市', '鄂州市', '荆门市', '孝感市', '荆州市', '黄冈市', '咸宁市', '随州市', '恩施土家族苗族自治州', '省直辖县'],
        ['长沙市', '株洲市', '湘潭市', '衡阳市', '邵阳市', '岳阳市', '常德市', '张家界市', '益阳市', '郴州市', '永州市', '怀化市', '娄底市', '湘西土家族苗族自治州'],
        ['广州市', '韶关市', '深圳市', '珠海市', '汕头市', '佛山市', '江门市', '湛江市', '茂名市', '肇庆市', '惠州市', '梅州市', '汕尾市', '河源市', '阳江市', '清远市', '东莞市', '中山市', '潮州市', '揭阳市', '云浮市'],
        ['南宁市', '柳州市', '桂林市', '梧州市', '北海市', '防城港市', '钦州市', '贵港市', '玉林市', '百色市', '贺州市', '河池市', '来宾市', '崇左市'],
        ['海口市', '三亚市', '三沙市', '省直辖县'],
        ['重庆市'],
        ['成都市', '自贡市', '攀枝花市', '泸州市', '德阳市', '绵阳市', '广元市', '遂宁市', '内江市', '乐山市', '南充市', '眉山市', '宜宾市', '广安市', '达州市', '雅安市', '巴中市', '资阳市', '阿坝藏族羌族自治州', '甘孜藏族自治州', '凉山彝族自治州'],
        ['贵阳市', '六盘水市', '遵义市', '安顺市', '毕节市', '铜仁市', '黔西南布依族苗族自治州', '黔东南苗族侗族自治州', '黔南布依族苗族自治州'],
        ['昆明市', '曲靖市', '玉溪市', '保山市', '邵通市', '丽江市', '普洱市', '临沧市', '楚雄彝族自治州', '红河哈尼族彝族自治州', '文山壮族苗族自治州', '西双版纳傣族自治州', '大理白族自治州', '德宏傣族景颇自治州', '怒江傈僳族自治州', '迪庆藏族自治州'],
        ['拉萨市', '日喀则市', '昌都市', '林芝市', '山南地区', '那曲地区', '阿里地区'],
        ['西安市', '铜川市', '宝鸡市', '咸阳市', '渭南市', '延安市', '汉中市', '榆林市', '安康市', '商洛市'],
        ['兰州市', '嘉峪关市', '金昌市', '白银市', '天水市', '武威市', '张掖市', '平凉市', '酒泉市', '庆阳市', '定西市', '陇南市', '临夏回族自治州', '甘南藏族自治州'],
        ['西宁市', '海东市', '海北藏族自治州', '黄南藏族自治州', '海南藏族自治州', '果洛藏族自治州', '玉树藏族自治州', '海西蒙古族藏族自治州'],
        ['银川市', '石嘴山市', '吴忠市', '固原市', '中卫市'],
        ['乌鲁木齐市', '克拉玛依市', '吐鲁番市', '哈密地区', '昌吉回族自治州', '博尔塔拉蒙古自治州', '巴音郭楞蒙古自治州', '阿克苏地区', '克孜勒苏柯尔克孜自治州', '喀什地区', '和田地区', '伊犁哈萨克自治州', '塔城地区', '阿勒泰地区', '自治区直辖县级行政区划'],
        ['台北市', '高雄市', '台南市', '台中市', '金门县', '南投县', '基隆市', '新竹市', '嘉义市', '新北市', '宜兰县', '新竹县', '桃源县', '苗栗县', '彰化县', '嘉义县', '云林县', '屏东县', '台东县', '花莲县', '澎湖县', '连江县'],
        ['香港岛', '九龙', '新界'],
        ['澳门半岛', '离岛']
      ];

/**
 * 传入相应参数返回圆形制定半径的弧度坐标
 * @param {*} x 中心点X坐标
 * @param {*} y 中心点y坐标
 * @param {*} R 圆半径
 * @param {*} a 角度
 */
function coordMap(x, y, R, a) {
    var ta = (360 - a) * Math.PI / 180,
        tx, ty;
    tx = R * Math.cos(ta); // 角度邻边
    ty = R * Math.sin(ta); // 角度的对边
    return {
        x: x + tx,
        y: y - ty // 注意此处是“-”号，因为我们要得到的Y是相对于（0,0）而言的。
    }
}

/**
 * 创建弧线
 * @param {*} data.startAngle 开始角度
 * @param {*} data.endAngle 结束角度
 * @param {*} data.R 圆半径
 * @param {*} data.x 中心点X坐标
 * @param {*} data.y 中心点y坐标
 * @param {*} data.color 边框颜色  默认#CCC
 * @param {*} data.strokeWidth 边框宽度 默认1
 * @param {*} data.strokelinecap 不同类型的路径的开始结束点 可选值 butt round square  默认butt
 * @param {*} data.strokeDasharray 虚线设置 它是一个<length>和<percentage>数列，数与数之间用逗号或者
 * 空白隔开，指定短划线和缺口的长度。如果提供了奇数个值，则这个值的数列重复一次，从而变成偶数个值。因此，5,3,2等同于5,3,2,5,3,2。
 * @param {*} data.transform CSS3旋转设置
 */
function drawSVG(data) {
    var path,
        // 起点坐标
        s = new coordMap(data.x, data.y, data.R, data.startAngle),
        // 结束坐标
        e = new coordMap(data.x, data.y, data.R, data.endAngle),
        // 创建弧线路径
        tpath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    // 画一段到(x,y)的椭圆弧. 椭圆弧的 x, y 轴半径分别为 rx,ry. 椭圆相对于 x 轴旋转 x-axis-rotation 度. large-arc=0表明弧线小于180读, large-arc=1表示弧线大于180度. sweep=0表明弧线逆时针旋转, sweep=1表明弧线顺时间旋转.
    // svg : [A | a] (rx ry x-axis-rotation large-arc-flag sweep-flag x y)+
    path = 'M' + s.x + ',' + s.y + 'A' + data.R + ',' + data.R + ',0,' + (+(data.endAngle - data.startAngle > 180)) + ',1,' + e.x + ',' + e.y;
    // 设置路径
    tpath.setAttribute('d', path);
    // 去掉填充
    tpath.setAttribute("fill", "none");
    // 设置颜色
    tpath.setAttribute('stroke', data.color || '#CCC');
    // 边线宽度
    tpath.setAttribute('stroke-width', data.strokeWidth || 1);
    data.transform ? tpath.setAttribute('transform', data.transform) : '';
    return tpath;
}
function drawArcByRadiusDeg(data) {
	var path,tpath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    var cw = typeof data.clockwise !== 'undefined' ? data.clockwise : 1;
    var x = data.startX - data.r + data.r*Math.cos(data.deg*Math.PI/180);
    var y = data.startY + (1===cw ? 1 : -1)*data.r*Math.sin(data.deg*Math.PI/180);
    var bigOrSmall = data.deg > 180 ? 1 : 0;
    var line = " L" + (data.startX - data.r) + " " + data.startY + " L"+data.startX + " " + data.startY + "Z";
    path = "M" + data.startX +" "+ data.startY + " A "+ data.r +" " + data.r + " 0 " + bigOrSmall + " " +cw+ " " + x + " " + y + line;
    tpath.setAttribute('d', path);
    tpath.setAttribute("fill", "#FFFFFF");
    tpath.setAttribute("fill-opacity", "1");
    data.transform ? tpath.setAttribute('transform', data.transform) : '';
    return tpath;
}
function svgView(el,percentage) {
	var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
	svg.setAttribute("version", "1.1"); // IE9+ support SVG 1.1 version
    $(el +' svg').empty()
    // 画轴线并加入SVG中
    svg.appendChild(new drawSVG({
        startAngle: 0,
        endAngle: 359,
        x: 18,
        y: 18,
        R: 16,
        color: '#FFFFFF',
        strokeWidth: 2,
        transform: 'rotate(-90, 18, 18)'
    }));
    // 步长
    var step = 360 / 100;
    svg.appendChild(new drawArcByRadiusDeg({
        startX: 34,
        startY: 18,
        r: 16,
        deg: step * percentage,
        transform: 'rotate(-90, 18, 18)'
    }));
    // 写入页面
    document.querySelector(el).appendChild(svg);
};

function queryParams(){
	var province = $('.province_list .active').html(),
	city = $('.city_list .active').html(),
	old = $('.old_list .active').html(),
	gender = $('.gender_type .active').html(),
	source = $('.source_type .active').html(),
	height = $('.height_type .active').html(),
	weight = $('.weight_type .active').html(),
	language = $('.language_ability .active').html(),
	personality = $('.personality_ability .active').html(),
	big_action = $('.big_action_ability .active').html(),
	small_action = $('.small_action_ability .active').html(),
	cognitive = $('.cognitive_ability .active').html(),
	self_help = $('.self_help_ability .active').html(),
	tooth = $('.tooth_situation .active').html();
	var query_name = $('.search_key').val();
}