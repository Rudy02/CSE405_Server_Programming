/*global React */
/*global ReactDOM*/
/*global mountNode*/
/*global ajax */
var LogoutButton = React.createClass({
  onLogout: function(){
    ajax('logout.php', null, function(response) {
     if (response.result === 'error') {
        alert('Error: ' + response.msg);
      } else {
          this.props.onLogout();
      }
    }.bind(this));
  },
  render: function(){
    return(
      <div>
        <input type='submit'  value='Logout' onClick={this.onLogout}/> <br/>
      </div>
      );
  }
});

var LoginForm = React.createClass({
  getInitialState: function(){
    return {
      username: 'alice',
      password: '1234'
    };
  },
  onUsernameChange: function(e){
    this.setState({username: e.target.value });
  },
  onPasswordChange: function(e){
    this.setState({password: e.target.value });
  },
  onSubmit: function(e){
    
    ajax('login.php', {username: this.state.username, password: this.state.password }, function(response) {
      if(response.result === 'failure') {
        alert('Wrong credential');
      } else if (response.result === 'success') {
       this.props.onLogin(response.clickCount);
      } else if (response.result === 'error') {
        alert('Error: ' + response.msg);
      } else {
          alert('Response message has no result attribute');
      }
    }.bind(this));

  },
  render: function() {
    return (
          <div>
          Username: <input type='text'        value={this.state.username} onChange={this.onUsernameChange}/> <br/>
          Password: <input type='password'    value={this.state.password} onChange={this.onPasswordChange}/> <br/>
                    <input type='submit'      value='Login'               onClick={this.onSubmit} /> <br/>
            </div>
    );
  }
});

var ClickButton = React.createClass({
  onClick: function() {
    ajax('record_click.php', null, function(response){
     if (response.result === 'success') {
       this.props.setClicks(response.clickCount);
     
      } else if (response.result === 'error') {
        alert('Error: ' + response.msg);
      } else {
          alert('Response message has no result attribute');
      }
    }.bind(this));
    },
  render: function() {
    return  <input type ='submit' value='Click Me' onClick={this.onClick} />;
  }
});

var ClickScreen = React.createClass({
  render: function() {
    return(
      <div>
          <div>Clicks: {this.props.clickCount}</div>
          <ClickButton setClicks={this.props.setClicks} />
          <LogoutButton onLogout={this.props.onLogout} />
      </div>
    );
  }
});


var LoginScreen = React.createClass({
  render: function() {
    return <LoginForm onLogin={this.props.onLogin} />;
  }
  
});
var LoadingScreen = React.createClass({
  render: function() {
    return <div>Loading...</div>;
  }
});

var App = React.createClass({
    getInitialState: function(){
         //clickCount set to nul;l means user is not logged in
        return { 
            loading: true,
            clickCount: null
        };
    },
    componentDidMount: function () {
        ajax('init.php', null , function(response) {
            if (response.result === 'error'){
                alert('Error: ' + response.msg);
            } else if (response.result === 'LoggedIn') {
                this.setState({clickCount: response.clickCount, loading: false});
            } else if (response.result === 'notLoggedIn') {
                this.setState({clickCount: null, loading: false });
            } else {
                alert('Response message has no result attribute.');
            }
        }.bind(this));
    },
    onLogin: function (clickCount){
        this.setState({clickCount: clickCount});
    },
    onLogout: function (){
        this.setState({clickCount: null});
    },
    setClick: function(clickCount) {
        this.setState({ clickCount: clickCount });
    },
    render: function() {
        if (this.state.loading) {
            return <LoadingScreen />;
        }else if (this.state.clickCount === null) {
            return <LoginScreen onLogin={this.onLogin} />;
        } else  { 
            return (
                <ClickScreen 
                    setClicks={this.setClick} 
                    onLogout={this.onLogout} 
                    clickCount={this.state.clickCount} 
                />
            );
        }
    }
});

ReactDOM.render(<App />,document.getElementById('content'));