<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <div class="clearfix"></div>
            <li><a href="<?= Yii::app()->request->baseUrl; ?>/colores/admin"><i class="fa fa-list-alt fa-fw">
                <div class="icon-bg bg-orange"></div>
                </i><span class="menu-title">Pedidos</span></a>
                <!-- <ul class="submenu">
                    <li class="li-no-style">
                        <a href="#"><i class="fa fa-book fa-fw">
                            <div class="icon-bg bg-pink"></div>
                            </i><span class="menu-title">Administrar</span>
                        </a> 
                    </li>
                </ul> -->
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
            <li class="<?php if($this->section == 'clientes'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/clientes/admin"><i class="fa fa-users fa-fw">
                <div class="icon-bg bg-blue"></div>
                </i><span class="menu-title">Clientes</span></a>
            </li>
            <li class="<?php if($this->section == 'materiales'){ echo 'active'; } ?>"><a href="<?= Yii::app()->request->baseUrl; ?>/materiales/admin"><i class="fa fa-wrench fa-fw">
                <div class="icon-bg bg-blue"></div>
                </i><span class="menu-title">Materiales</span></a>
            </li>
            <li><a href="#"><i class="fa fa-file-pdf-o fa-fw">
                <div class="icon-bg bg-red"></div>
                </i><span class="menu-title">Reportes</span></a>
            </li>
        </ul>
    </div>
</nav>