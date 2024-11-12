import ChevronDown from 'vue-material-design-icons/ChevronDown';
import ChevronUp from 'vue-material-design-icons/ChevronUp';
import ChevronRight from 'vue-material-design-icons/ChevronRight';
import PlusThick from 'vue-material-design-icons/PlusThick';
import MinusThick from 'vue-material-design-icons/MinusThick';
import ArrowUp from 'vue-material-design-icons/ArrowUp';
import ArrowRight from 'vue-material-design-icons/ArrowRight';
import CheckCircle from 'vue-material-design-icons/CheckCircle';
import Segment from 'vue-material-design-icons/Segment';
import Close from 'vue-material-design-icons/Close';

const mdiPlugin = {
  install(app) {
    // Lista de componentes a registrar globalmente
    const components = {
      ChevronDown,
      ChevronUp,
      ChevronRight,
      PlusThick,
      MinusThick,
      ArrowUp,
      ArrowRight,
      CheckCircle,
      Segment,
      Close,
    };

    // Registra cada componente globalmente
    Object.entries(components).forEach(([name, component]) => {
      app.component(name, component);
    });
  },
};

export default mdiPlugin;
