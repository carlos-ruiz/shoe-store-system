<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <div class="clearfix"></div>
            <li class="<?php if($this->section == 'pedidos'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/pedidos/admin"><i class="fa fa-list-alt fa-fw">
                <div class="icon-bg bg-orange"></div>
                </i><span class="menu-title">Pedidos</span></a>
            </li>
            <li class="<?php if($this->section == 'modelos'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/modelos/admin"><i class="fa fa-book fa-fw">
                <div class="icon-bg bg-pink"></div>
                </i><span class="menu-title">Modelos</span></a> 
            </li>
            <li class="<?php if($this->section == 'colores'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/colores/admin"><i class="fa fa-paint-brush fa-fw">
                <div class="icon-bg bg-green"></div>
                </i><span class="menu-title">Colores</span></a>
            </li>
            <li class="<?php if($this->section == 'suelas'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/suelas/admin"><i class="fa fa-database fa-fw">
                <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Suelas</span></a>
            </li>
            <li class="<?php if($this->section == 'tacones'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/tacones/admin"><i class="fa fa-database fa-fw">
                <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Tacones</span></a>
            </li>
            <li class="<?php if($this->section == 'agujetas'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/agujetas/admin"><i class="fa fa-random fa-fw">
                <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Agujetas</span></a>
            </li>
            <li class="<?php if($this->section == 'ojillos'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/ojillos/admin"><i class="fa fa-circle-o fa-fw">
                <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Ojillos</span></a>
            </li>
            <li class="<?php if($this->section == 'clientes'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/clientes/admin"><i class="fa fa-users fa-fw">
                <div class="icon-bg bg-blue"></div>
                </i><span class="menu-title">Clientes</span></a>
            </li>
            <li class="<?php if($this->section == 'materiales'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/materiales/admin"><i class="fa fa-wrench fa-fw">
                <div class="icon-bg bg-blue"></div>
                </i><span class="menu-title">Materiales</span></a>
            </li>
            <li class="<?php if($this->section == 'insumos'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/insumos/admin"><i class="fa fa-cogs fa-fw">
                <div class="icon-bg bg-blue"></div>
                </i><span class="menu-title">Insumos</span></a>
            </li>
            <li class="<?php if($this->section == 'etiquetas'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/modelos/generarEtiqueta"><i class="fa fa-tag fa-fw">
                <div class="icon-bg bg-red"></div>
                </i><span class="menu-title">Etiquetas</span></a>
            </li>
            <li class="<?php if($this->section == 'inventarios'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/inventarios/index"><i class="fa fa-cubes fa-fw">
                <div class="icon-bg bg-red"></div>
                </i><span class="menu-title">Inventarios</span></a>
            </li>
            <li class="menu <?php if($this->section == 'extras'){ echo 'active'; } ?>"><a href="#"><i class="fa fa-chevron-circle-down fa-fw">
                <div class="icon-bg bg-red"></div>
                </i><span class="menu-title">Extras</span></a>
                <ul class="submenu">
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'formas_pago'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/formasPago/admin">
                            <i class="fa fa-credit-card fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Formas de pago</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'estatus_pedido'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/estatusPedidos/admin">
                            <i class="fa fa-hourglass-start fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Estatus de pedidos</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'estatus_pagos'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/estatusPagos/admin">
                            <i class="fa fa-money fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Estatus de pagos</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'estatus_zapatos'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/estatusZapatos/admin">
                            <i class="fa fa-cart-arrow-down fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Estatus de zapatos</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'perfiles_usuarios'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/perfilesUsuarios/admin">
                            <i class="fa fa-users fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Perfiles de usuarios</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'zapatos'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/zapatos/admin">
                            <i class="fa fa-usd fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Configurar precios</span>
                        </a>
                    </li>
                    <li class="<?php if(isset($this->subsection) && $this->subsection == 'numeros_suelas_modelos'){ echo 'submenu-active'; } ?>">
                        <a href="<?= Yii::app()->request->baseUrl; ?>/modelossuelasnumeros/admin">
                            <i class="fa fa-sort-numeric-asc fa-fw">
                                <div class="icon-bg bg-red"></div>
                            </i>
                            <span class="menu-title">Configurar números</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-file-pdf-o fa-fw">
                <div class="icon-bg bg-red"></div>
                </i><span class="menu-title">Reportes</span></a>
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
        $(".submenu").toggle();
    });
</script>