import React from 'react';
import PropTypes from 'prop-types';
import { Button, Card, CardText, CardTitle, Col, Collapse, Container, Nav, Navbar, NavbarBrand, NavbarToggler, NavLink, NavItem, Row } from 'reactstrap';
import Select from 'react-select';
import 'bootstrap/dist/css/bootstrap.css';
import 'react-select/dist/react-select.css';

class CmsMenu extends React.Component {
  constructor(props) {
    super(props);

    // this is for test
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

    this.handleCollapseMenu = this.handleCollapseMenu.bind(this);
    this.handleCollapseMenuAll = this.handleCollapseMenuAll.bind(this);
    this.state = { collapse: [], isOpen: false };
  }

  componentDidMount() {
    const { endPoint } = this.props;
  }

  renderMenuSelector(menus) {
    return (
      <Select options={menus.map(menu => ({ value: menu.id, label: menu.title }))} />
    );
  }

  handleCollapseMenu(id) {
    this.setState({
      collapse: Object.assign({}, this.state.collapse, {
        [id]: !this.state.collapse[id]
      })
    });
  }


  renderMenus(menus) {
    return menus.map(menu => {
      if (menu.children) {
        return (
          <div>
            <Button color="link" onClick={() => this.handleCollapseMenu(menu.id)}>
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
            <NavbarToggler onClick={this.handleCollapseMenuAll} />
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
