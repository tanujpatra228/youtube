import logo from './logo.svg';
import './App.css';
import Posts from './components/pages/Posts';

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <Posts/>
      </header>
    </div>
  );
}

export default App;
