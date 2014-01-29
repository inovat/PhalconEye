{#
  +------------------------------------------------------------------------+
  | PhalconEye CMS                                                         |
  +------------------------------------------------------------------------+
  | Copyright (c) 2013 PhalconEye Team (http://phalconeye.com/)            |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconeye.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Author: Ivan Vorontsov <ivan.vorontsov@phalconeye.com>                 |
  +------------------------------------------------------------------------+
#}

{% extends "../../Core/View/layouts/admin.volt" %}

{% block title %}{{ 'Roles'|trans }}{% endblock %}

{% block head %}
    <script type="text/javascript">
        var deleteItem = function (id) {
            if (confirm('{{ "Are you really want to delete this role?" | trans}}')) {
                window.location.href = '{{ url(['for':'admin-roles-delete'])}}' + id;
            }
        }
    </script>
{% endblock %}

{% block header %}
    <div class="navbar navbar-header">
        <div class="navbar-inner">
            {{ navigation.render() }}
        </div>
    </div>
{% endblock %}

{% block content %}
    <div class="span12">
        <div class="row-fluid">
            <h2>{{ 'Roles' | trans }} ({{ paginator.items | length }})</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ 'Id' | trans }}</th>
                    <th>{{ 'Name' | trans }}</th>
                    <th>{{ 'Description' | trans }}</th>
                    <th>{{ 'Is default?' | trans }}</th>
                    <th>{{ 'Options' | trans }}</th>
                </tr>
                </thead>
                <tbody>
                {% for item in paginator.items %}
                    <tr>
                        <td>
                            {{ item.id }}
                        </td>
                        <td>
                            {{ item.name }}
                        </td>
                        <td>
                            {{ item.description }}
                        </td>
                        <td>
                            {% if item.is_default %}
                                {{ 'Yes' |trans }}
                            {% else %}
                                {{ 'No' |trans }}
                            {% endif %}
                        </td>
                        <td>
                            {{ link_to(['for':'admin-roles-edit', 'id':item.id], 'Edit' | trans) }}
                            {% if not item.undeletable %}
                                {{ link_to(null, 'Delete' | trans, "onclick": 'deleteItem('~ item.id ~');return false;') }}
                            {% endif %}
                        </td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
            {{ partial("paginator") }}
        </div>
        <!--/ row -->
    </div><!--/span-->

{% endblock %}
