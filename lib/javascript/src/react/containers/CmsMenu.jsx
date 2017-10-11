import React from 'react';
import PropTypes from 'prop-types';
import { Button, Container, Row, Card, CardText, CardTitle, Col, Collapse, Nav, Navbar, NavbarBrand, NavbarToggler, NavLink, NavItem } from 'reactstrap';
import Select from 'react-select';
//import '../components/CmsMenu.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'react-select/dist/react-select.css';

class CmsMenu extends React.Component {
  constructor(props) {
    super(props);

    this.menus = [
      { id:1, title:'>> 메뉴1', children: [
        { id:2, url:'/test/2', title:'메뉴2' },
        { id:3, url:'/test/3', title:'메뉴3' },
      ]},
      { id:4, title:'>> 메뉴4', children: [
        { id:5, url:'/test/5', title:'메뉴5' },
        { id:6, url:'/test/6', title:'메뉴6' },
      ]},
    ];

    this.handleToggleCollapse = this.handleToggleCollapse.bind(this);
    this.toggle2 = this.toggle2.bind(this);
    this.state = { collapse: [], isOpen: false };
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

  componentDidMount() {
    const { endPoint } = this.props;
  }

  renderMenuSelector(menus) {
    return (
      <Select options={menus.map(menu => ({ value: menu.id, label: menu.title }))} />
    );
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

  handleToggleCollapse(id) {
    this.setState({
      collapse: Object.assign({}, this.state.collapse, {
        [id]: !this.state.collapse[id]
      })
    });
  }

  toggle2() {
    this.setState({ isOpen: !this.state.isOpen });
  }

  renderMenus(menus) {
    return menus.map(menu => {
      if (menu.children) {
        return (
          <div>
            <Button color="link" onClick={() => this.handleToggleCollapse(menu.id)}>
              <h6>{menu.title}</h6>
            </Button>
            <Collapse
              isOpen={!!this.state.collapse[menu.id]}
              style={{ paddingLeft: '15px' }}
              navbar
            >
              { this.renderMenus(menu.children) }
            </Collapse>
            <hr style={{ margin: 0 }} />
          </div>
        )
      } else {
        return (
          <NavItem>
            <NavLink href={menu.url}>{menu.title}</NavLink>
          </NavItem>
        )
      }
    });
  }

  render() {
    return (
      <div>
        <Card className="d-none d-lg-block" style={{ padding: '10px' }} body>
          <CardTitle>Ridibooks CMS</CardTitle>
          <CardText>
            { this.renderMenuSelector(this.menus) }
            <Nav vertical>
              { this.renderMenus(this.menus) }
              <hr style={{ margin: 0 }} />
              <NavItem>
                <NavLink href="/me">개인정보 수정</NavLink>
              </NavItem>
              <NavItem>
                <NavLink href="/logout">Logout</NavLink>
              </NavItem>
            </Nav>
          </CardText>
        </Card>
        <div className="d-lg-none">
          <Navbar color="faded" light expand="lg">
            <NavbarBrand href="/">Ridibooks CMS</NavbarBrand>
            <NavbarToggler onClick={this.toggle2} />
            <Collapse isOpen={this.state.isOpen} navbar>
              <Nav className="ml-auto" navbar>
                <NavItem>
                  <NavLink href="/components/">Components</NavLink>
                </NavItem>
                <NavItem>
                  <NavLink href="https://github.com/reactstrap/reactstrap">Github</NavLink>
                </NavItem>
              </Nav>
            </Collapse>
          </Navbar>
        </div>
      </div>
    );
  }
}

CmsMenu.propTypes = {
  endPoint: PropTypes.string.isRequired,
};

export default CmsMenu;
