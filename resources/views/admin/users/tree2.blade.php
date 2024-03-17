<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /*----------------genealogy-scroll----------*/

        .genealogy-scroll::-webkit-scrollbar {
            width: 5px;
            height: 8px;
        }

        .genealogy-scroll::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e4e4e4;
        }

        .genealogy-scroll::-webkit-scrollbar-thumb {
            background: #212121;
            border-radius: 10px;
            transition: 0.5s;
        }

        .genealogy-scroll::-webkit-scrollbar-thumb:hover {
            background: #d5b14c;
            transition: 0.5s;
        }


        /*----------------genealogy-tree----------*/

        * {
            margin: 0;
            padding: 0;
        }

        .tree {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }

        .tree ul {
            padding-left: 20px;
            position: relative;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 5px 0 5px 20px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*We will use ::before and ::after to draw the connectors*/

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 50%;
            border-left: 1px solid #ccc;
            width: 20px;
            height: 50%;
        }

        .tree li::after {
            bottom: auto;
            top: 50%;
            border-top: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without
any siblings*/
        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/
        .tree li:only-child {
            padding-left: 0;
        }

        /*Remove left connector from first child and
right connector from last child*/
        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before {
            border-bottom: 1px solid #ccc;
            border-radius: 0 0 5px 0;
            -webkit-border-radius: 0 0 5px 0;
            -moz-border-radius: 0 0 5px 0;
        }

        .tree li:first-child::after {
            border-radius: 0 0 0 5px;
            -webkit-border-radius: 0 0 0 5px;
            -moz-border-radius: 0 0 0 5px;
        }

        /*Time to add downward connectors from parents*/
        .tree ul ul::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            border-top: 1px solid #ccc;
            width: 20px;
            height: 0;
        }

        .tree li a {
            border: 1px solid #ccc;
            padding: 10px 5px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            -ms-flex-item-align: center;
            -ms-grid-row-align: center;
            align-self: center;

            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li a:hover,
        .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }

        /*Connector styles on hover*/
        .tree li a:hover+ul li::after,
        .tree li a:hover+ul li::before,
        .tree li a:hover+ul::before,
        .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }

        /*--------------memeber-card-design----------*/
        .member-view-box {
            padding: 0px 20px;
            text-align: center;
            border-radius: 4px;
            position: relative;
        }

        .member-image {
            width: 60px;
            position: relative;
        }

        .member-image img {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            background-color: #000;
            z-index: 1;
        }
    </style>
</head>

<body>
<!--
We will create a family tree using just CSS(3)
The markup will be simple nested lists
-->
<div class="body genealogy-body genealogy-scroll">
    <div class="genealogy-tree tree">
        <ul>
            @foreach ($tree as $familyMember)
                <li>
                    <a href="#">
                        <div class="member-view-box">
                            <div class="member-image">
                                <img loading="lazy" src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?w=2000"
                                     alt="Member">
                                <div class="member-details">
                                    <h3>{{ $familyMember->mobile }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    @if (isset($familyMember->children) && count($familyMember->children) > 0)
                        @include('tree', ['children' => $familyMember->children])
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

{{--<div class="tree genealogy-tree horizontal-tree">--}}
{{--    <ul>--}}
{{--        @foreach ($tree as $familyMember)--}}
{{--            <li>--}}
{{--                <a href="#">{{ $familyMember->mobile }}</a>--}}
{{--                @if (isset($familyMember->children) && count($familyMember->children) > 0)--}}
{{--                    @include('tree', ['children' => $familyMember->children])--}}
{{--                @endif--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
{{--</div>--}}

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function () {
        $('.genealogy-tree ul').hide();
        $('.genealogy-tree>ul').show();
        $('.genealogy-tree ul.active').show();
        $('.genealogy-tree li').on('click', function (e) {
            var children = $(this).find('> ul');
            if (children.is(":visible")) children.hide('fast').removeClass('active');
            else children.show('fast').addClass('active');
            e.stopPropagation();
        });
    });
</script>

</html>
