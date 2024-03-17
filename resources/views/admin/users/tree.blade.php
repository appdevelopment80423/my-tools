@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
    @push('page-css')
    <style>
        .window {
            font-weight: bold;
            cursor: pointer;
            border: 1px solid #346789;
            box-shadow: 2px 2px 10px #aaa;
            -o-box-shadow: 2px 2px 10px #aaa;
            -webkit-box-shadow: 2px 2px 10px #aaa;
            -moz-box-shadow: 2px 2px 10px #aaa;
            -moz-border-radius: 0.5em;
            border-radius: 0.5em;
            /*
            opacity:0.8;
            filter:alpha(opacity=80);
            */
            width: 10em;
            height: auto;
            padding: 0.5em 0em;
            text-align: center;
            z-index: 20;
            position: absolute;
            background-color: #eeeeef;
            color: black;
            font-family: helvetica;
            font-size: 0.9em;
            word-wrap: break-word;
        }

        .window:hover {
            box-shadow: 2px 2px 10px #444;
            -o-box-shadow: 2px 2px 10px #444;
            -webkit-box-shadow: 2px 2px 10px #444;
            -moz-box-shadow: 2px 2px 10px #444;
            /*
            opacity:0.6;
            filter:alpha(opacity=60);
            */
        }

        /*
        .window > div {
            margin-top: 19%;
            margin-bottom: 19%;
        }
        */

        .hidden {
            display: none;
        }

        .collapser {
            cursor: pointer;
            border: 1px dotted gray;
            z-index: 21;
        }

        .errorWindow {
            border: 2px solid red;
        }

        #treemain {
            height: 500px;
            width: 100%;
            position: relative;
            overflow: auto;
        }
    </style>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div id="treemain">
                <div id="node_0" class="window hidden"
                     data-id="0"
                     data-parent=""
                     data-first-child="1"
                     data-next-sibling="">
                    Root
                </div>
                @foreach($users as $i => $user)
                    <div id="node_{{ $user->id }}" class="window hidden"
                         data-id="{{ $user->id }}"
                         data-parent="{{ ($loop->first) ? 0 : $user->parent_id }}"
                         data-first-child="{{ $user->first_child ?? '' }}"
                         data-next-sibling="{{ $user->next_sibling ?? '' }}">
                        {{ $user->getUser->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/1.7.10/jsPlumb.min.js"
                integrity="sha512-A1gTsaWUck7mkEu6D8/938PKlkVS79TkgqAloQbGU4bhOPUBS9JVknN5x++J3eRNO8g6D/T3kqhHBd4KkqRNxg=="
                crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{asset('assets/js/jsplumb-tree.js')}}"></script>

        <script type="text/javascript">
            // -- init -- //
            jsPlumb.ready(function () {

                // connection lines style
                var connectorPaintStyle = {
                    lineWidth: 3,
                    strokeStyle: "#4F81BE",
                    joinstyle: "round"
                };

                var pdef = {
                    // disable dragging
                    DragOptions: null,
                    // the tree container
                    Container: "treemain"
                };
                var plumb = jsPlumb.getInstance(pdef);

                // all sizes are in pixels
                var opts = {
                    prefix: 'node_',
                    // left margin of the root node
                    baseLeft: 24,
                    // top margin of the root node
                    baseTop: 24,
                    // node width
                    nodeWidth: 100,
                    // horizontal margin between nodes
                    hSpace: 36,
                    // vertical margin between nodes
                    vSpace: 10,
                    imgPlus: 'tree_expand.png',
                    imgMinus: 'tree_collapse.png',
                    // queste non sono tutte in pixel
                    sourceAnchor: [1, 0.5, 1, 0, 10, 0],
                    targetAnchor: "LeftMiddle",
                    sourceEndpoint: {
                        endpoint: ["Image", {url: "tree_collapse.png"}],
                        cssClass: "collapser",
                        isSource: true,
                        connector: ["Flowchart", {stub: [40, 60], gap: [10, 0], cornerRadius: 5, alwaysRespectStubs: false}],
                        connectorStyle: connectorPaintStyle,
                        enabled: false,
                        maxConnections: -1,
                        dragOptions: null
                    },
                    targetEndpoint: {
                        endpoint: "Blank",
                        maxConnections: -1,
                        dropOptions: null,
                        enabled: false,
                        isTarget: true
                    },
                    connectFunc: function (tree, node) {
                        var cid = node.data('id');
                        // console.log('Connecting node ' + cid);
                    }
                };
                var tree = jQuery.jsPlumbTree(plumb, opts);
                tree.init();
                window.treemain = tree;
            });

            function positioningBlockBug() {
                var oldNode = window.treemain.nodeById(2);
                //var newNode = $('#node_2_new');
                var newNode = $('    <div id="node_2" class="window hidden"\n' +
                    '         data-id="2"\n' +
                    '         data-parent="0"\n' +
                    '         data-first-child="6"\n' +
                    '         data-next-sibling="3">\n' +
                    '        Node 2 NEW\n' +
                    '    </div>\n');
                if (oldNode) {
                    // butta il nodo nel container
                    oldNode.replaceWith(newNode);
                    // rimostra il nodo
                    newNode.id = 'node_2';
                    newNode.show();
                    // aggiorna l'albero
                    window.treemain.update();
                }

            }

            {{--$(document).ready(function() {--}}
            {{--    $.ajax({--}}
            {{--        url: '{{url('getRootNodes')}}',--}}
            {{--        type: 'GET',--}}
            {{--        dataType: 'json',--}}
            {{--        data:{--}}
            {{--          'user_id':1--}}
            {{--        },--}}
            {{--        success: function(nodes) {--}}
            {{--            appendNodes('treemain', nodes);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            {{--function loadChildren(parentId) {--}}
            {{--    let url = "{{url('getChildNodes')}}/"+parentId;--}}
            {{--    $.ajax({--}}
            {{--        url: url,--}}
            {{--        type: 'GET',--}}
            {{--        dataType: 'json',--}}
            {{--        success: function(nodes) {--}}
            {{--            appendNodes(`node_${parentId}`, nodes);--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}

            {{--function appendNodes(parentId, nodes) {--}}
            {{--    nodes.forEach(node => {--}}
            {{--        if(typeof(node.first_child) != "undefined" && node.first_child !== null) {--}}
            {{--            node.first_child = '';--}}
            {{--        }--}}

            {{--        if(typeof(node.next_sibling) != "undefined" && node.next_sibling !== null) {--}}
            {{--            node.first_child = '';--}}
            {{--        }--}}

            {{--        let newNodeHtml = `--}}
            {{--        <div id="node_${node.id - 1}" class="window"--}}
            {{--            data-id="${node.id - 1}"--}}
            {{--            data-parent="${node.parent_id}"--}}
            {{--            data-first-child="${node.first_child}"--}}
            {{--            data-next-sibling="${node.next_sibling}"--}}
            {{--            onclick="loadChildren(${node.id})">--}}
            {{--            Node ${node.id}--}}
            {{--        </div>`;--}}

            {{--        $(`#treemain`).append(newNodeHtml);--}}
            {{--    });--}}
            {{--}--}}


        </script>
    @endpush
@endsection

