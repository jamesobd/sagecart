(function() {
  var template = Handlebars.template, templates = App.Templates.Partials = App.Templates.Partials || {};
Handlebars.partials['sub'] = template({"1":function(depth0,helpers,partials,data,blockParams,depths) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <li class=\"category active\"><a class=\"category-nav\" href=\"/category/"
    + alias3(((helper = (helper = helpers.CategoryCode || (depth0 != null ? depth0.CategoryCode : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"CategoryCode","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.CategoryCodeDesc || (depth0 != null ? depth0.CategoryCodeDesc : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"CategoryCodeDesc","hash":{},"data":data}) : helper)))
    + "</a>\r\n"
    + ((stack1 = (helpers.compare || (depth0 && depth0.compare) || alias1).call(depth0,(depth0 != null ? depth0.Parent : depth0),"==",(depths[1] != null ? depths[1].CategoryCode : depths[1]),{"name":"compare","hash":{},"fn":this.program(2, data, 0, blockParams, depths),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </li>\r\n";
},"2":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = this.invokePartial(partials.sub,depth0,{"name":"sub","data":data,"indent":"        ","helpers":helpers,"partials":partials})) != null ? stack1 : "");
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data,blockParams,depths) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.categories : depth0),{"name":"each","hash":{},"fn":this.program(1, data, 0, blockParams, depths),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\r\n";
},"usePartial":true,"useData":true,"useDepths":true});
})();