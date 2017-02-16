{% block css %}
    <style>
        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .button {
            font-size: 18px;
            padding: 5px 5px;
            background-color: #31b0d5;
        }
    </style>
{% endblock %}

{% block content %}
    <div class="content">
        <form action="/login" method="post">
            <hello></hello>
            <?=csrf_field()?>
            <div class="title">username <input type="text" name="username" value=""></div>
            <div class="title">password <input type="password" name="password" value=""></div>
            <div class="title"><a class="button" href="javascript:;">login</a></div>
        </form>
    </div>
{% endblock %}