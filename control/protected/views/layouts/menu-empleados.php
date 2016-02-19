<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <div class="clearfix"></div>
            <li class="<?php if($this->section == 'pedidos'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/pedidos/seguimientoPedidos"><i class="fa fa-list-alt fa-fw">
                <div class="icon-bg bg-orange"></div>
                </i><span class="menu-title">Seguimiento de pedidos</span></a>
            </li>
        </ul>
    </div>
</nav>

<script type="text/javascript">
    $('.submenu').each(function(){
        if($(this).parent().hasClass('active')){
            $(this).show();
        }
    });
    $('.menu>a').click(function(){
        $(this).parent().children(".submenu").slideToggle();
    });
</script>