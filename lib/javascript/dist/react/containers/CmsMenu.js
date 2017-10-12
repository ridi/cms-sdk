'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _propTypes = require('prop-types');

var _propTypes2 = _interopRequireDefault(_propTypes);

var _reactstrap = require('reactstrap');

var _reactSelect = require('react-select');

var _reactSelect2 = _interopRequireDefault(_reactSelect);

require('bootstrap/dist/css/bootstrap.css');

require('react-select/dist/react-select.css');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }
//import '../components/CmsMenu.css';


var CmsMenu = function (_React$Component) {
  _inherits(CmsMenu, _React$Component);

  function CmsMenu(props) {
    _classCallCheck(this, CmsMenu);

    var _this = _possibleConstructorReturn(this, (CmsMenu.__proto__ || Object.getPrototypeOf(CmsMenu)).call(this, props));

    _this.menus = [{ id: 1, title: '>> 메뉴1', children: [{ id: 2, url: '/test/2', title: '메뉴2' }, { id: 3, url: '/test/3', title: '메뉴3' }] }, { id: 4, title: '>> 메뉴4', children: [{ id: 5, url: '/test/5', title: '메뉴5' }, { id: 6, url: '/test/6', title: '메뉴6' }] }];

    _this.handleToggleCollapse = _this.handleToggleCollapse.bind(_this);
    _this.toggle2 = _this.toggle2.bind(_this);
    _this.state = { collapse: [], isOpen: false };
    return _this;
  }

  /*
   menu [
    {
      id
      menu_url
      menu_title
      menu_deep
      ajax_array [
        ajax_url
      ]
    }
  ]
    */

  _createClass(CmsMenu, [{
    key: 'componentDidMount',
    value: function componentDidMount() {
      var endPoint = this.props.endPoint;
    }
  }, {
    key: 'renderMenuSelector',
    value: function renderMenuSelector(menus) {
      return _react2.default.createElement(_reactSelect2.default, { options: menus.map(function (menu) {
          return { value: menu.id, label: menu.title };
        }) });
    }

    /*
     <ul className="nav nav-pills nav-stacked">
     <ul className="nav nav-pills nav-stacked collapse in">
     {
       menus.map(menu => {
         if (!menu.url) {
           return <li key={menu.id}><h5 style={{ margin: '10px 15px' }}><a data-toggle="collapx`se" data-target={`#drilldown-${menu.id}`}>{menu.title}</a></h5></li>
         } else {
           return <li key={menu.id}><a href={menu.url} target={menu.isNewtab ? '_blank' : '_self'}>{menu.title}</a></li>
         }
       })
     }
     </ul>
     </ul>
     */

  }, {
    key: 'handleToggleCollapse',
    value: function handleToggleCollapse(id) {
      this.setState({
        collapse: Object.assign({}, this.state.collapse, _defineProperty({}, id, !this.state.collapse[id]))
      });
    }
  }, {
    key: 'toggle2',
    value: function toggle2() {
      this.setState({ isOpen: !this.state.isOpen });
    }
  }, {
    key: 'renderMenus',
    value: function renderMenus(menus) {
      var _this2 = this;

      return menus.map(function (menu) {
        if (menu.children) {
          return _react2.default.createElement(
            'div',
            null,
            _react2.default.createElement(
              _reactstrap.Button,
              { color: 'link', onClick: function onClick() {
                  return _this2.handleToggleCollapse(menu.id);
                } },
              _react2.default.createElement(
                'h6',
                null,
                menu.title
              )
            ),
            _react2.default.createElement(
              _reactstrap.Collapse,
              {
                isOpen: !!_this2.state.collapse[menu.id],
                style: { paddingLeft: '15px' },
                navbar: true
              },
              _this2.renderMenus(menu.children)
            ),
            _react2.default.createElement('hr', { style: { margin: 0 } })
          );
        } else {
          return _react2.default.createElement(
            _reactstrap.NavItem,
            null,
            _react2.default.createElement(
              _reactstrap.NavLink,
              { href: menu.url },
              menu.title
            )
          );
        }
      });
    }
  }, {
    key: 'render',
    value: function render() {
      return _react2.default.createElement(
        'div',
        null,
        _react2.default.createElement(
          _reactstrap.Card,
          { className: 'd-none d-lg-block', style: { padding: '10px' }, body: true },
          _react2.default.createElement(
            _reactstrap.CardTitle,
            null,
            'Ridibooks CMS'
          ),
          _react2.default.createElement(
            _reactstrap.CardText,
            null,
            this.renderMenuSelector(this.menus),
            _react2.default.createElement(
              _reactstrap.Nav,
              { vertical: true },
              this.renderMenus(this.menus),
              _react2.default.createElement('hr', { style: { margin: 0 } }),
              _react2.default.createElement(
                _reactstrap.NavItem,
                null,
                _react2.default.createElement(
                  _reactstrap.NavLink,
                  { href: '/me' },
                  '\uAC1C\uC778\uC815\uBCF4 \uC218\uC815'
                )
              ),
              _react2.default.createElement(
                _reactstrap.NavItem,
                null,
                _react2.default.createElement(
                  _reactstrap.NavLink,
                  { href: '/logout' },
                  'Logout'
                )
              )
            )
          )
        ),
        _react2.default.createElement(
          'div',
          { className: 'd-lg-none' },
          _react2.default.createElement(
            _reactstrap.Navbar,
            { color: 'faded', light: true, expand: 'lg' },
            _react2.default.createElement(
              _reactstrap.NavbarBrand,
              { href: '/' },
              'Ridibooks CMS'
            ),
            _react2.default.createElement(_reactstrap.NavbarToggler, { onClick: this.toggle2 }),
            _react2.default.createElement(
              _reactstrap.Collapse,
              { isOpen: this.state.isOpen, navbar: true },
              _react2.default.createElement(
                _reactstrap.Nav,
                { className: 'ml-auto', navbar: true },
                _react2.default.createElement(
                  _reactstrap.NavItem,
                  null,
                  _react2.default.createElement(
                    _reactstrap.NavLink,
                    { href: '/components/' },
                    'Components'
                  )
                ),
                _react2.default.createElement(
                  _reactstrap.NavItem,
                  null,
                  _react2.default.createElement(
                    _reactstrap.NavLink,
                    { href: 'https://github.com/reactstrap/reactstrap' },
                    'Github'
                  )
                )
              )
            )
          )
        )
      );
    }
  }]);

  return CmsMenu;
}(_react2.default.Component);

CmsMenu.propTypes = {
  endPoint: _propTypes2.default.string.isRequired
};

exports.default = CmsMenu;